# Database of car brands with PHP and JSON
__This first sample project with PHP is now finished. ✅__

Next steps: Conversion to a real database, use of the PHP framework for standard tasks

## Features
* Implementation of simple CRUD (Create, Read, Update, Delete) functionality of car brands
* Data is stored as a JSON text file
* Website is repsonsive for smaller screens

## Project struture
```
/
├── css/
│   └── stylesheet.css
├── data/
│   ├── cars.json
│   └── formhandler.php
├── fonts/
│   ├── fonts/open-sans-v40-latin-regular.ttf
│   └── fonts/open-sans-v40-latin-regular.woff2
├── img/
│   ├── add.svg
│   ├── cancel.svg
│   ├── car.jpg
│   ├── delete.svg
│   ├── edit.svg
│   ├── home.svg
│   ├── list.svg
│   └── user.svg
├── templates/
│   ├── add_frame.html
│   ├── delete_frame.html
│   ├── edit_frame.html
│   ├── footer.html
│   ├── header.html
│   ├── html_head.html
│   ├── main_template.html
│   ├── navigation.html
│   ├── show_frame.html
│   └── welcome.html
└── index.php
```
Computations are done in `index.php` (as a kind of Controller) and `formhandler.php` (act solely as a Model, no visual representation here).

## Box-Modell

```
/
├── head/
│   └── <link rel="stylesheet" href="./css/stylesheet.css">
└── body/
    ├── header
    ├── navigation
    ├── main {padding 16px;}
    │   └── <div class='content_box'> Here are the data presented in a rounded box
    |       |
    │       ├── <table> for "Welcome"
    │       │
    │       ├── <div class='scroll_box'> for "Show"
    │       │   ├── <div class='card'>
    │       │   ├── <div class='card'>
    │       │   ├── <div class='card'>
    │       │   ├── <div class='card'>
    │       │   └── ...
    │       │
    │       ├── <div class='card'> for "Delete"
    │       │
    │       └── <form> for "Add" and "Edit"
    │   
    └──  footer

```

## New in Version 0.3
 * Significantly improved separation of logic from presentation using HTML templates:
   * "Welcome"-Screen, "Show all Cars"-Screen and forms for "Add", "Edit" and "Delete" are still deployed from `index.php` using templates (`show_frame.html`, `edit_frame.html`, `add_frame.html`, `delete_frame.html` and `welcome.html`)
   * All 'echoed' parts are collected in an output buffer (`ob_start()` and `ob_get_cleaned()`) and then used for filling the `main_template.html` template
   * This main template consists of different sub templates (`html_head.html`, `header.html`, `navigation.html` and `footer.html`)
   * However all the data manipulation is done in `formhandler.php`

 * Improvements in UI:
    * CSS: `box-sizing: border-box;` for definitive sizing and `scrollbar-width: auto !important;` for thicker scrollbars
    * CSS: define `height = 100%;` in html and body to give full height in child containers
    * Adding and Modify forms have now also an "Abort" button
    * Pressing on "Delete" button results in confirmation dialog
    * Updated forms for adding, deleting and modifying new cars
    * Adding and editing forms have now labels
    * Updated "Welcome" screen shows now a short introduction
    * CSS is updated to include "Abort" buttons in a different color
    * Changing the user icon and user background color
    * Only the _main container_ is now scrollable, the rest of the site is static
    * The h1 heading is only used once per website (all other headings become h2)
    * Add media queries for __responsiveness__ - when the screen is 700px wide or less:
      * header and footer disappear
      * padding of _main container_ shrinks from 16px to 2px;
      * buttons shrink to show only the icons
      * _card_ containers have now word-wrap

 * Better protection against irregular use of URL parameters
 * Consequent use of `<?= $something ?>` as echo shortcut
 * Creation of comprehensive documentation

## Ideas for further improvements
 * Update information (e.g. “Data such-and-such has been added”) could be displayed as HTML/CSS popovers, e.g. similar to https://mdn.github.io/dom-examples/popover-api/blur-background/




 
