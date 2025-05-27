import path from 'path';
import syntaxHighlight from "@11ty/eleventy-plugin-syntaxhighlight";
import { DateTime } from 'luxon';
export default function(eleventyConfig) {

    const isProduction = process.env.NODE_ENV === 'production';
    const mediaUrlPrefix = isProduction ? process.env.MEDIA_URL_PREFIX : '/assets';
    eleventyConfig.addPlugin(syntaxHighlight);
    eleventyConfig.addPassthroughCopy("bundle.css");
    eleventyConfig.addFilter("readableDate", (dateObj) => {
        return DateTime.fromJSDate(dateObj, { zone: 'utc' }).toLocaleString(DateTime.DATE_HUGE);
    });

    eleventyConfig.addPassthroughCopy("content/assets/*.{jpg,jpeg,png,gif,svg,webp,mp4,pdf}");

    eleventyConfig.addTransform("fix-asset-paths", async function(content) {
        if (this.page.inputPath.startsWith('./posts/') && this.page.outputPath.endsWith('.html')) {
            const relativePathRegex = /(href|src)="(?!\/|#|http|https)([^"]+)"/g;
            return content.replace(relativePathRegex, (match, attribute, src) => {
                const newPath = `${mediaUrlPrefix}/${src}`;
                return `${attribute}="${newPath}"`;
            });
        }
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
