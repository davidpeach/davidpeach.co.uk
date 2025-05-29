// _data/webmentions.js
import EleventyFetch from "@11ty/eleventy-fetch";
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const MENTIONS_STORAGE_PATH = path.join(__dirname, 'webmentions_storage.json');
const DOMAIN = "davidpeach.me";

function readFromCache() {
  if (fs.existsSync(MENTIONS_STORAGE_PATH)) {
    const cacheFile = fs.readFileSync(MENTIONS_STORAGE_PATH);
    try {
      return JSON.parse(cacheFile.toString());
    } catch (e) {
      console.error("Error parsing webmentions cache file. Returning empty cache.", e);
      return { lastFetched: null, mentions: [] };
    }
  }
  return { lastFetched: null, mentions: [] };
}

function writeToCache(data) {
  fs.writeFileSync(MENTIONS_STORAGE_PATH, JSON.stringify(data, null, 2));
  console.log(`>>> Cached ${data.mentions.length} webmentions to ${MENTIONS_STORAGE_PATH}`);
}

export default async function() {
  console.log(">>> Fetching webmentions...");
  const cachedData = readFromCache();
  let allMentions = cachedData.mentions || []; 

  const TOKEN = process.env.WEBMENTION_IO_TOKEN;

  if (!TOKEN) {
    console.warn("⚠️ No WEBMENTION_IO_TOKEN found in environment variables. Using only cached webmentions (if any).");
    // Group by URL for Eleventy
    return allMentions.reduce((acc, mention) => {
        const targetUrl = mention['wm-target'];
        if (acc[targetUrl]) acc[targetUrl].push(mention);
        else acc[targetUrl] = [mention];
        return acc;
    }, {});
  }

  let fetchUrl = `https://webmention.io/api/mentions.jf2?domain=${DOMAIN}&token=${TOKEN}&per-page=1000`;

  if (allMentions.length > 0) {
    // Find the ID of the newest mention in the cache to use with `since_id`
    // Ensure there's at least one mention before trying to reduce
    const newestMention = allMentions.reduce((a, b) => (a['wm-id'] > b['wm-id'] ? a : b), allMentions[0]);
    if (newestMention && newestMention['wm-id']) {
      fetchUrl += `&since_id=${newestMention['wm-id']}`;
      console.log(`>>> Fetching new mentions since ID: ${newestMention['wm-id']}`);
    }
  } else {
    console.log(">>> No cached mentions found, fetching all mentions.");
  }

  try {
    const newMentionsResponse = await EleventyFetch(fetchUrl, {
      duration: "0s",
      type: "json",
      verbose: process.env.ELEVENTY_SERVERLESS === 'true' || false,
    });

        // --- START DEBUGGING EMOJIS ---
    if (newMentionsResponse && newMentionsResponse.children && newMentionsResponse.children.length > 0) {
      console.log("------------------------------------------------------------");
      console.log("DEBUGGING EMOJI IN FETCHED DATA (first 3 mentions if available):");
      for (let i = 0; i < Math.min(3, newMentionsResponse.children.length); i++) {
        const mention = newMentionsResponse.children[i];
        console.log(`\n--- Mention ${i + 1} ---`);
        console.log(`Raw mention object (author & content snippet):`, { 
          author_name: mention.author ? mention.author.name : 'N/A', 
          content_text: mention.content ? mention.content.text : 'N/A',
          // You might want to log the whole mention object if it's small enough
          // or if you need to inspect other fields for the problematic mention
          // For example: full_mention_object: mention 
        });
        // Specifically log the fields you expect emojis in
        if (mention.author && mention.author.name) {
            console.log(`Mention ${i + 1} raw author.name:`, mention.author.name);
        }
        if (mention.content && mention.content.text) {
          console.log(`Mention ${i + 1} raw content.text:`, mention.content.text);
        }
      }
      console.log("------------------------------------------------------------");
    } else if (newMentionsResponse) {
      console.log("DEBUGGING EMOJI: newMentionsResponse received, but no children or empty children array:", newMentionsResponse);
    } else {
      console.log("DEBUGGING EMOJI: newMentionsResponse is null or undefined after fetch.");
    }

    if (newMentionsResponse && newMentionsResponse.children) {
      console.log(`>>> ${newMentionsResponse.children.length} new webmentions fetched from webmention.io`);
      
      const newMentionIds = new Set(newMentionsResponse.children.map(m => m['wm-id']));
      allMentions = allMentions.filter(m => !newMentionIds.has(m['wm-id'])); 
      allMentions.push(...newMentionsResponse.children);

      // Sort all mentions by wm-id (or received date) to keep them consistent
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
  }

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
