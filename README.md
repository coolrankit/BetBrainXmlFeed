# BetBrainXmlFeed
BetBrain.com XML Data Feed Capturing, Parsing, Formatting

This PHP script uses host's cron job function to get xml feed from betbrain.com and parses, filters and formats the data in a specific structure and updates into the database.
Developed and tested on PHP5.

Instructions:
1. Edit the rdb.php file and set your database credentials properly.
2. Your database must have some specific table. All the needful table structure are defined in DbStructure.php file. Add the tables into the database manually.
3. Set a cron job to the url of feeder/cron.php file with your preferable interval time.
4. You can check the working of the script manually also by browsing to the url of index.php through web browser.
