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

        if (isProduction && this.page.outputPath.endsWith('.html')) {
            const mediaUrlPrefix = process.env.MEDIA_URL_PREFIX;

            // Don't run if the production URL isn't set
            if (!mediaUrlPrefix) {
                return content;
            }

            // Find all relative paths that start with "assets/"
            const assetPathRegex = /(href|src)="(assets\/[^"]+)"/g;

            return content.replace(assetPathRegex, (match, attribute, src) => {
                // Prepend the full cloud URL to the existing path.
                // `src` is already "assets/image.jpg"
                const newPath = `${mediaUrlPrefix}/${src}`; 
                return `${attribute}="${newPath}"`;
            });
        }

        // In development, return the content without any changes
        return content;
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
