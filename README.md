# codelab - my ideas
### This is a place where I put code I wrote
### I am the author of all of it


----------

## ip_updater

 - This is a solution for people having IP address that changes over time and prevents you from having your own server. This solution consists of two files: saver and redirect. First file calls API and writes new IP to text file if it changes. Then it uploads that file to another server. When you go to address from that server script reads text file content and redirects to IP it has in text file. Two options may be used for each saver and redirect: saver in PHP or in python and redirect in PHP or html+js (contains XMLHttpRequest() method). This ip_updater has been designed for my own purposes: I needed a redirect to my own weather station.

## filelist.php

 - Uses php scandir() to show content of current directory. By clicking a link you can go deeper into folders or go back. 

## mail.php

 - Code that has been used to handle sending emails from my page. It has a mechanism that prevents sending too many emails daily

## donpedro.js

 - JavaScript code that is responsible for simple game mechanism. HTML and other parts are not included. Written in few hours just to have fun!