# Tech Tutorial Idea Aggregator 🚀

A modern content curation dashboard built with Laravel 11 to help tech writers and developers brainstorm future tutorial topics. 

**Live Application:** [http://tutorial-aggregator.phptutorialpoints.in/](http://tutorial-aggregator.phptutorialpoints.in/)

Instead of manually scouring the web for inspiration, this application automatically fetches trending articles from the Dev.to API every night, allowing you to search, bookmark, and draft your own tutorial outlines in one centralized workspace.

## ✨ Features

- **Automated Curation:** A scheduled background job pulls the top trending articles for specific tags (PHP, React, Python, JavaScript) daily.
- **Full-Text Search:** Powered by Laravel Scout (Database driver) to instantly filter hundreds of saved articles.
- **Inspiration Board:** Bookmark the best articles to save them to a dedicated workspace.
- **Markdown Drafting:** Write tutorial outlines directly under bookmarked articles with a live, Alpine.js-powered HTML preview.
- **Secure Access:** Dashboard is protected by Laravel Breeze authentication.

## 🛠 Tech Stack

- **Backend:** Laravel 11, PHP 8.2+
- **Database & Search:** SQLite, Laravel Scout
- **Frontend:** Blade, Tailwind CSS, Alpine.js, Tailwind Typography
- **External API:** Dev.to (Forem) API

## 🚀 Local Installation

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/YOUR_USERNAME/tutorial-aggregator.git](https://github.com/YOUR_USERNAME/tutorial-aggregator.git)
   cd tutorial-aggregator