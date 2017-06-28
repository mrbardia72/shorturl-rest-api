# shorturl-api
Link shortener program (php+json)
The first step is to implement the shortening program Need to download permission.sql and urls.sql  batch in y mysql
1. The original file to run (Url.php)
2. Configuration file and functions to run the program(includes/function.php)
3. To run, you must enter the browser's address below.
4. example
5. api/url.php?url=www.iran.ir&key=2203
6. output In the form json
7. {
    "msg": "stored in the database",
    "url_short": "url.ir/S5RdphJ",
    "date": "2017-06-28",
    "time": "15:37:58",
    "your username": "jajiga",
    "counter create shorturl": 6
}
