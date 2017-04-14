Steps to execute the PHP script:
-----------------------------------

	-> Create a new folder at the location "C:\wamp\www\".
	-> Next we need to copy the php files(connectDB, queries) into the newly created folder.
	-> After copying the files, open the file 'connectDB' and edit the $conn statement as shown below with the required details.
	-> $conn = mysqli_connect("localhost", "WampID", "Password", "Database Name consisting all the tables in wamp");
	-> Then open the browser and in the address bar type as follows - http://localhost/(Name of the folder created above)/queries.php.
	-> Once the address is typed, press Enter. The PHP script to run the DB queries will execute and you will see the UI with queries to be executed.



Trigger One Explanation:
----------------------------------

- This trigger is invoked while we try to insert any data into the table Director.
- It checks whether the total movies directed(tot_mov_drctd) column in the table is greater than zero or not.
- If a person is called as a director he needs to direct atleast one movie. 
- If the tot_mov_drctd value while inserting is less than '1' then the trigger is invoked and the message 'Needs to direct atleast one movie' is displayed. 

Trigger Two Explanation:
----------------------------------

- This trigger is invoked while we try to delete data from the table Movie.
- It checks whether the count of movie_id in the Film_genre table, whether it's greater than '0'.
- If the movie entry is deleted from the movie table, then the respective entry in film_genre needs to be deleted as Movie and Film_genre have referential Integrity.
- If the Count is greater than, then the trigger is invoked and the message 'You cannot delete a Movie Record because its in Film_Genre' is displayed.


