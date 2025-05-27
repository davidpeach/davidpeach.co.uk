import path from 'path';
import syntaxHighlight from "@11ty/eleventy-plugin-syntaxhighlight";
import { DateTime } from 'luxon';

export default function(eleventyConfig) {

    const isProduction = process.env.NODE_ENV === 'production';
    // const mediaUrlPrefix = isProduction ? process.env.MEDIA_URL_PREFIX : '/assets';

    eleventyConfig.addPlugin(syntaxHighlight);
    eleventyConfig.addPassthroughCopy("bundle.css");
    eleventyConfig.addFilter("readableDate", (dateObj) => {
        return DateTime.fromJSDate(dateObj, { zone: 'utc' }).toLocaleString(DateTime.DATE_HUGE);
    });

    eleventyConfig.addPassthroughCopy("content/assets/*.{jpg,jpeg,png,gif,svg,webp,mp4,pdf}");

    eleventyConfig.addTransform("fix-asset-paths", async function(content) {
        // Log context for every file being transformed
        const inputPathForLog = this.page && this.page.inputPath ? this.page.inputPath : "N/A";
        const outputPathForLog = this.page && this.page.outputPath ? this.page.outputPath : "N/A";
        console.log(`[Transform] Attempting to process: Input='${inputPathForLog}', Output='${outputPathForLog}'`);
        console.log(`[Transform] Value of 'isProduction' (from outer scope): ${isProduction}`);

        // Check conditions for applying production logic
        if (isProduction && outputPathForLog && outputPathForLog.endsWith('.html')) {
            console.log(`[Transform] Applying PRODUCTION logic for: ${outputPathForLog}`);

            const productionMediaUrlPrefix = process.env.MEDIA_URL_PREFIX; // Re-check within transform scope for safety
            console.log(`[Transform] Value of process.env.MEDIA_URL_PREFIX inside transform: ${productionMediaUrlPrefix}`);

            if (!productionMediaUrlPrefix || productionMediaUrlPrefix.trim() === '') {
                console.warn(`[Transform] WARNING: MEDIA_URL_PREFIX is empty or not set in production for ${outputPathForLog}. No replacements will be made.`);
                return content;
            }

            const assetPathRegex = /(href|src)="(\/assets\/[^"]+)"/g;
            let matchFound = false;
            // ----> ADD THIS LINE <----
            const newContent = content.replace(assetPathRegex, (match, attribute, srcPath) => {
                matchFound = true;
                const newFullPath = new URL(srcPath, productionMediaUrlPrefix).href;
                console.log(`[Transform] For ${outputPathForLog}: Found "${match}". Replacing with "${attribute}="${newFullPath}"`);
                return `${attribute}="${newFullPath}"`;
            });

            if (!matchFound) {
                console.log(`[Transform] For ${outputPathForLog}: No paths matching 'assets/...' were found to replace.`);
            }
            return newContent;

        } else {
            if (!isProduction) {
                console.log(`[Transform] Skipping production logic for ${outputPathForLog} because 'isProduction' is false.`);
            } else if (!outputPathForLog || !outputPathForLog.endsWith('.html')) {
                console.log(`[Transform] Skipping production logic for ${outputPathForLog} because it's not an HTML file.`);
            }
            return content; // Return content untouched for development or non-HTML files
        }
    });
    return {
        dir: {
            input: "content", // <--- Set this to "posts"
            includes: "../_includes", // You may need this if your _includes folder is outside of 'posts'
            date: "../_data",
            output: "_site",
        }
    };
};
