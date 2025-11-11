# Landing Page + PHP Task

## Getting Started

Docker and docker-compose are required.  
Run in the terminal:
- `docker-compose up`

---

## Tasks

1. Check and fix errors related to, among others:
   - the `docker-compose.yml` configuration,
   - form security,
   - page responsiveness.
2. Implement sending form data to the `contact.php` script.
3. Implement saving data to the `submissions.json` file in the `contact.php` script:
   - besides the form data, also save the submission date.
4. Perform a brief analysis of the page regarding performance, accessibility, and SEO (e.g., using Lighthouse) and describe what and how you improved.

#### Analysis of point 4.
Performance:
- It is simple light-weight, fast loading page with one huge big image, fortunately cached by browser itself.

Accessibility:
- Accessibility is poor, no aria labels, defined tab-indexes. No WCAG switches for <span style="color: yellow">contrast</span> or HUGE FONT
- Bad layout design: 
  - <span style="color: #000001">weak contrast</span><span style="color: white"> (apart from the blinding white fields) 
  - <span style="font-size: 8px">too small</span> font and <span style="font-family: 'Comic Sans MS', cursive, sans-serif">toy font type</span>
  -barely visible action button
  - I am not good at mobile designs, but there are big fields as well as the button.
  
- SEO was improved by adding title and meta tags

---

## Structure

- `index.html` - front-end
- `contact.php` - backend
- `styles/` - SCSS styles (compiled to CSS)
- `docker-compose.yml` - Docker configuration
- `submissions.json` - file for saved submissions

---

Good luck!
