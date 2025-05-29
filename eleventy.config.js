import path from 'path';
import syntaxHighlight from "@11ty/eleventy-plugin-syntaxhighlight";
import { feedPlugin } from "@11ty/eleventy-plugin-rss";
// import { eleventyImageTransformPlugin } from "@11ty/eleventy-img";
import { DateTime } from 'luxon';

export default function(eleventyConfig) {

    const isProduction = process.env.NODE_ENV === 'production';

    eleventyConfig.addPlugin(syntaxHighlight);

    eleventyConfig.addPlugin(feedPlugin, {
        type: "atom", // or "rss", "json"
        outputPath: "/feed.xml",
        collection: {
            name: "posts", // iterate over `collections.posts`
            limit: 20,     // 0 means no limit
        },
        metadata: {
            language: "en",
            title: "David Peach's Website",
            subtitle: "David Peach's Website",
            base: "https://davidpeach.me/",
            author: {
                name: "David Peach",
                email: "mail@davidpeach.co.uk",
            }
        }
    });



    // eleventyConfig.addPlugin(eleventyImageTransformPlugin);
    eleventyConfig.addPassthroughCopy("bundle.css");
    eleventyConfig.addFilter("readableDate", (dateObj) => {
        return DateTime.fromJSDate(dateObj, { zone: 'utc' }).toLocaleString(DateTime.DATE_HUGE);
    });

    // Ensure this part is present
    eleventyConfig.addFilter("split", function(str, separator) {
        if (typeof str !== 'string') {
            return [];
        }
        return str.split(separator);
    });

    eleventyConfig.addPassthroughCopy("content/assets/*.{jpg,jpeg,png,gif,svg,webp,mp4,pdf}");

    eleventyConfig.addTransform("fix-asset-paths", async function(content) {

        if (! isProduction) {
            return content;
        }

        const assetPathRegex = /(href|src)="(\/assets\/[^"]+)"/g;
        const newContent = content.replace(assetPathRegex, (match, attribute, srcPath) => {
            const newFullPath = new URL(srcPath, process.env.MEDIA_URL_PREFIX).href;
            return `${attribute}="${newFullPath}"`;
        });

        return newContent;
    });

    return {
        dir: {
            input: "content",
            includes: "../_includes",
            data: "../_data",
            output: "_site",
        }
    };
};
