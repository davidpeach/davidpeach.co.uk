---
title: VP
---

<style>
    /* Basic Reset & Body Styling */
    body {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        margin: 0;
        background-color: #f0f0f0;
        color: #333;
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    /* Carousel Container: Holds the track and provides a viewport */
    .carousel-container {
        max-width: 90%; /* Max width of the carousel on the page */
        margin: 2rem auto; /* Center it */
        overflow: hidden; /* Crucial for hiding non-visible parts of the track */
        position: relative; /* For potential future absolute positioned nav buttons */
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        background-color: #fff;
        padding: 1rem 0; /* Padding top/bottom, track will handle horizontal */
    }

    /* Carousel Track: The scrollable area containing all items */
    .carousel-track {
        display: flex; /* Lays out items in a row */
        overflow-x: auto; /* Enables horizontal scrolling */
        scroll-snap-type: x mandatory; /* Core of the carousel: snaps on X-axis, always snaps to an item */
        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */

        /* Hide scrollbar for a cleaner look (cross-browser) */
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* IE and Edge */
    }
    .carousel-track::-webkit-scrollbar { /* Chrome, Safari, Opera */
        display: none;
    }

    /* Add some padding to the start and end of the track so items don't touch edges */
    /* This also works with scroll-snap */
    .carousel-track::before,
    .carousel-track::after {
        content: '';
        display: block;
        width: 1rem; /* Adjust as needed, can be 0 if you prefer edge-to-edge */
    }


    /* Carousel Item: Each individual image/link in the carousel */
    .carousel-item {
        flex: 0 0 auto; /* Prevents items from growing or shrinking */
        /* Responsive width for items: min 120px, preferred 35vw, max 220px */
        /* Adjust these values based on your image aspect ratio and desired look */
        width: clamp(120px, 35vw, 220px); 
        scroll-snap-align: start; /* Snaps the start of the item to the start of the container */
        /* scroll-snap-align: center; /* Alternative: snaps center of item to center of container */

        margin-right: 1rem; /* Spacing between items, modern alternative is 'gap' on .carousel-track */
        /* If using gap on .carousel-track, remove margin-right here and ::before/::after content for padding */
        /* Example with gap:
.carousel-track {
...
gap: 1rem;
padding: 0 1rem; // for space at start/end if gap doesn't cover it
}
*/
        display: block; /* Make the <a> tag a block container */
        text-decoration: none;
        border-radius: 8px;
        overflow: hidden; /* Ensures image corners also get rounded if image itself isn't */
        transition: transform 0.3s ease;
    }

    .carousel-item:last-child {
        margin-right: 0; /* No margin for the last item if not using gap */
    }

    .carousel-item:hover {
        transform: translateY(-5px); /* Slight hover effect */
    }

    .carousel-item picture,
    .carousel-item img {
        display: block; /* Remove extra space below image */
        width: 100%;   /* Make image fill the item's width */
        height: auto;  /* Maintain aspect ratio */
        /* For vertical images, you might want a consistent height and object-fit
e.g., height: 300px; object-fit: cover; 
But for this basic version, 'height: auto' is more flexible.
*/
        border-radius: 8px; /* If item itself doesn't have overflow:hidden */
        background-color: #e9e9e9; /* Placeholder background for images */
    }

    /* Styling for the content within the carousel item, if any (e.g., captions) */
    .carousel-item-caption {
        padding: 0.5rem;
        font-size: 0.9rem;
        color: #555;
        text-align: center;
        background-color: #fff; /* If items are just images, this might not be needed */
    }
</style>

<div class="carousel-container">
    <div class="carousel-track">
        <a href="https://placehold.co/800x1200/3498db/ffffff?text=Full+Image+1" target="_blank" class="carousel-item" aria-label="View full size image 1">
            <picture>
                <source srcset="https://placehold.co/200x300/3498db/ffffff?text=Image+1&.webp" type="image/webp">
                <img src="https://placehold.co/200x300/3498db/ffffff?text=Image+1" 
                    alt="Description of Image 1" 
                    loading="lazy" 
                    decoding="async">
            </picture>
        </a>
        <a href="https://placehold.co/800x1200/2ecc71/ffffff?text=Full+Image+2" target="_blank" class="carousel-item" aria-label="View full size image 2">
            <picture>
                <source srcset="https://placehold.co/200x300/2ecc71/ffffff?text=Image+2&.webp" type="image/webp">
                <img src="https://placehold.co/200x300/2ecc71/ffffff?text=Image+2" 
                    alt="Description of Image 2" 
                    loading="lazy" 
                    decoding="async">
            </picture>
        </a>
        <a href="https://placehold.co/800x1200/e74c3c/ffffff?text=Full+Image+3" target="_blank" class="carousel-item" aria-label="View full size image 3">
            <picture>
                <source srcset="https://placehold.co/200x300/e74c3c/ffffff?text=Image+3&.webp" type="image/webp">
                <img src="https://placehold.co/200x300/e74c3c/ffffff?text=Image+3" 
                    alt="Description of Image 3" 
                    loading="lazy" 
                    decoding="async">
            </picture>
        </a>
        <a href="https://placehold.co/800x1200/f39c12/ffffff?text=Full+Image+4" target="_blank" class="carousel-item" aria-label="View full size image 4">
            <picture>
                <source srcset="https://placehold.co/200x300/f39c12/ffffff?text=Image+4&.webp" type="image/webp">
                <img src="https://placehold.co/200x300/f39c12/ffffff?text=Image+4" 
                    alt="Description of Image 4" 
                    loading="lazy" 
                    decoding="async">
            </picture>
        </a>
        <a href="https://placehold.co/800x1200/9b59b6/ffffff?text=Full+Image+5" target="_blank" class="carousel-item" aria-label="View full size image 5">
            <picture>
                <source srcset="https://placehold.co/200x300/9b59b6/ffffff?text=Image+5&.webp" type="image/webp">
                <img src="https://placehold.co/200x300/9b59b6/ffffff?text=Image+5" 
                    alt="Description of Image 5" 
                    loading="lazy" 
                    decoding="async">
            </picture>
        </a>
    </div>
</div>
