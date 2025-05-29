// _data/webmentions.js
const EleventyFetch = require("@11ty/eleventy-fetch");
const fs = require('fs');
const path = require('path');
require('dotenv').config();

const CACHE_DIR = path.join(__dirname, '../.cache'); // Store cache in project root/.cache
const MENTIONS_CACHE_PATH = path.join(CACHE_DIR, 'webmentions.json');
const DOMAIN = "davidpeach.me";

// Helper function to ensure cache directory exists
function ensureCacheDir() {
  if (!fs.existsSync(CACHE_DIR)) {
    fs.mkdirSync(CACHE_DIR, { recursive: true });
  }
}

// Helper function to read mentions from local cache
function readFromCache() {
  ensureCacheDir();
  if (fs.existsSync(MENTIONS_CACHE_PATH)) {
    const cacheFile = fs.readFileSync(MENTIONS_CACHE_PATH);
    return JSON.parse(cacheFile.toString());
  }
  return { lastFetched: null, mentions: [] }; // Return shape consistent with API response structure
}

// Helper function to write mentions to local cache
function writeToCache(data) {
  ensureCacheDir();
  fs.writeFileSync(MENTIONS_CACHE_PATH, JSON.stringify(data, null, 2));
  console.log(`>>> Cached ${data.mentions.length} webmentions to ${MENTIONS_CACHE_PATH}`);
}

module.exports = async function() {
  console.log(">>> Fetching webmentions...");
  const cachedData = readFromCache();
  let allMentions = cachedData.mentions || []; // Start with cached mentions

  const TOKEN = process.env.WEBMENTION_IO_TOKEN;
  if (!TOKEN) {
    console.warn("⚠️ No WEBMENTION_IO_TOKEN found. Using only cached webmentions (if any).");
    // Group by URL for Eleventy
    return allMentions.reduce((acc, mention) => {
        const targetUrl = mention['wm-target'];
        if (acc[targetUrl]) acc[targetUrl].push(mention);
        else acc[targetUrl] = [mention];
        return acc;
    }, {});
  }

  let fetchUrl = `https://webmention.io/api/mentions.jf2?domain=${DOMAIN}&token=${TOKEN}&per-page=1000`;

  // If we have cached mentions, try to fetch only new ones
  // Find the ID of the newest mention in the cache to use with `since_id`
  if (allMentions.length > 0) {
    const newestMention = allMentions.reduce((a, b) => (a['wm-id'] > b['wm-id'] ? a : b));
    if (newestMention && newestMention['wm-id']) {
      fetchUrl += `&since_id=${newestMention['wm-id']}`;
      console.log(`>>> Fetching new mentions since ID: ${newestMention['wm-id']}`);
    }
  } else {
    console.log(">>> No cached mentions found, fetching all mentions.");
  }

  try {
    const newMentionsResponse = await EleventyFetch(fetchUrl, {
      duration: "0s", // We're caching locally, so always fetch fresh from API unless it's down
      type: "json",
      verbose: process.env.ELEVENTY_SERVERLESS,
    });

    if (newMentionsResponse && newMentionsResponse.children) {
      console.log(`>>> ${newMentionsResponse.children.length} new webmentions fetched from webmention.io`);
      
      // Combine and de-duplicate
      const newMentionIds = new Set(newMentionsResponse.children.map(m => m['wm-id']));
      allMentions = allMentions.filter(m => !newMentionIds.has(m['wm-id'])); // Remove old versions of new mentions
      allMentions.push(...newMentionsResponse.children);

      // Sort all mentions by wm-id to keep them consistent (optional, but good practice)
      allMentions.sort((a, b) => new Date(a['wm-received'] || 0) - new Date(b['wm-received'] || 0));

      writeToCache({
        lastFetched: new Date().toISOString(),
        mentions: allMentions
      });
    } else if (newMentionsResponse && newMentionsResponse.children.length === 0) {
        console.log(">>> No new mentions found on webmention.io.");
    }

  } catch (err) {
    console.warn(`>>> ERROR fetching new webmentions: ${err.message}. Falling back to cache.`);
    // If API fetch fails, we'll just use what's in `allMentions` (which is initially from cache)
  }

  // Group by URL for Eleventy
  const mentionsByUrl = {};
  for (const mention of allMentions) {
    const targetUrl = mention['wm-target'];
    if (mentionsByUrl[targetUrl]) {
      mentionsByUrl[targetUrl].push(mention);
    } else {
      mentionsByUrl[targetUrl] = [mention];
    }
  }
  return mentionsByUrl;
};
