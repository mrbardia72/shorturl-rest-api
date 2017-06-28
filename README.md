# shorturl-api
Link shortener program (php+json)
0. The first step is to implement the shortening program Need to download date.sql batch in y mysql
1. The original file to run (Url.php)
2. Configuration file and functions to run the program(includes/function.php)
3. To run, you must enter the browser's address below.
3-1. example
3-2. api/url.php?url=www.jajiga.ir&key=2203
3-3. output In the form json
3-4. {
    "msg": "stored in the database",
    "url_short": "url.ir/S5RdphJ",
    "date": "2017-06-28",
    "time": "15:37:58",
    "your username": "jajiga",
    "counter create shorturl": 6
}
