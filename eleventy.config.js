import path from 'path';
import syntaxHighlight from "@11ty/eleventy-plugin-syntaxhighlight";
// import { eleventyImageTransformPlugin } from "@11ty/eleventy-img";
import { DateTime } from 'luxon';

export default function(eleventyConfig) {

    const isProduction = process.env.NODE_ENV === 'production';

    eleventyConfig.addPlugin(syntaxHighlight);
    // eleventyConfig.addPlugin(eleventyImageTransformPlugin);
    eleventyConfig.addPassthroughCopy("bundle.css");
    eleventyConfig.addFilter("readableDate", (dateObj) => {
        return DateTime.fromJSDate(dateObj, { zone: 'utc' }).toLocaleString(DateTime.DATE_HUGE);
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
