<?php
	require './connectDB.php';
?>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<link href='//fonts.googleapis.com/css?family=Aclonica' rel='stylesheet'>
<link href='//fonts.googleapis.com/css?family=Fauna One' rel='stylesheet'>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<style type='text/css'>
.container{
	margin-top: 3%;
}
.table{
	width: 100%;
}
</style>
</head>
<body>

<div class="container">
	
		<table class='table'>
			<tr>
				<form method='post' action='./queries.php' class="form-horizontal">
					<td>1. What are all the awards won by movie 
						
					
						<select name='mid'>
							<?php
								$query = "SELECT movie_id,title from movie";
								$res = mysqli_query($conn,$query);

								while($row = mysqli_fetch_assoc($res)){
									echo "<option value=".$row['movie_id'].">".$row['title']." - ".$row['movie_id']."</option>";
								}
							?>
						</select>
					</td>
					<td>
						<button type="submit" class="btn btn-default" name='awards'>Submit</button>
					</td>
				</form>
			</tr>
			<tr>
				<form method='post' action='./queries.php' class="form-horizontal">
					<td>2. List all the movies directed by a director 
						
					
						<select name='did'>
							<?php
								$query = "SELECT Dname,ID from director";
								$res = mysqli_query($conn,$query);

								while($row = mysqli_fetch_assoc($res)){
									echo "<option value=".$row['ID'].">".$row['Dname']." - ".$row['ID']."</option>";
								}
							?>
						</select>

						that belong to
						<select name='genre'>
							<?php
								$query = "SELECT DISTINCT genre from film_genre";
								$res = mysqli_query($conn,$query);

								while($row = mysqli_fetch_assoc($res)){
									echo "<option value=".$row['genre'].">".$row['genre']."</option>";
								}
							?>
						</select>
					</td>
					<td>
						<button type="submit" class="btn btn-default" name='dir_genre'>Submit</button>
					</td>
				</form>
			</tr>
			<tr>
				<form method='post' action='./queries.php' class="form-horizontal">
					<td>3. Find the names of producers and directors whose career earnings are greater than
						<input type='text' name='earns' placeholder=">EARNINGS">
					</td>
					<td>
						<button type="submit" class="btn btn-default" name='earnings'>Submit</button>
					</td>
				</form>
			</tr>
			<tr>
				<form method='post' action='./queries.php' class="form-horizontal">
					<td>4.Find the award winning movies that have 
						<input type='text' name='rate' placeholder="RATING">
					</td>
					<td>
						<button type="submit" class="btn btn-default" name='rating'>Submit</button>
					</td>
				</form>
			</tr>
			<tr>
				<form method='post' action='./queries.php' class="form-horizontal">
					<td>5. Finding the names of all the authors whose ranking is greater than those in industry
						<select name='inds'>
							<?php
								$query = "SELECT DISTINCT industry from author";
								$res = mysqli_query($conn,$query);

								while($row = mysqli_fetch_assoc($res)){
									echo "<option value=".$row['industry'].">".$row['industry']."</option>";
								}
							?>
						</select>
					</td>
					<td>
						<button type="submit" class="btn btn-default" name='author'>Submit</button>
					</td>
				</form>
			</tr>
		</table>
	
	<?php
		if(isset($_POST['awards'])){
			$mid = $_POST['mid'];
			$query = "SELECT award_name FROM movie_award WHERE movie_id='".$mid."'";
			$res = mysqli_query($conn,$query);
			echo "<table class='table table-striped'>
					<thead>
						<tr>
							<th>Award Name</th>
						</tr>
					</thead>
					<tbody>";
			while($row = mysqli_fetch_assoc($res)){
				echo "<tr>

						<td>". $row['award_name']."</td>

						</tr>";
			}
			echo "	</tbody>
				</table>";
		}
		if(isset($_POST['dir_genre'])){
			$genre = $_POST['genre'];
			$did = $_POST['did'];
			$query = "SELECT movie.movie_id , title FROM movie,film_genre WHERE movie.movie_id = film_genre.movie_id AND genre='".$genre."' AND dir_id='".$did."'";
			$res = mysqli_query($conn,$query);
			echo "<table class='table table-striped'>
					<thead>
						<tr>
							<th>Movie ID</th>
							<th>Title</th>
						</tr>
					</thead>
					<tbody>";
			while($row = mysqli_fetch_assoc($res)){
				echo "<tr>

						<td>". $row['movie_id']."</td>
						<td>". $row['title']."</td>
						</tr>";
			}
			echo "	</tbody>
				</table>";
		}
		if(isset($_POST['earnings'])){
			$earns = $_POST['earns'];
			$query = "SELECT Dname 
					    from director 
					    where career_earnings>".$earns."
					    UNION 
					    select pname 
					    from producer 
					    where career_earnings>".$earns;
			$res = mysqli_query($conn,$query);
			echo "<table class='table table-striped'>
					<thead>
						<tr>
							<th>Dname</th>
						</tr>
					</thead>
					<tbody>";
			while($row = mysqli_fetch_assoc($res)){
				echo "<tr>

						<td>". $row['Dname']."</td>
						</tr>";
			}
			echo "	</tbody>
				</table>";
		}

		if(isset($_POST['rating'])){
			$rate = $_POST['rate'];
			$query = "SELECT DISTINCT title as MovieName
					    from movie_award,movie
					    WHERE movie_award.movie_id=movie.movie_id
					    and rating =".$rate;
			$res = mysqli_query($conn,$query);
			echo "<table class='table table-striped'>
					<thead>
						<tr>
							<th>MovieName</th>
						</tr>
					</thead>
					<tbody>";
			while($row = mysqli_fetch_assoc($res)){
				echo "<tr>

						<td>". $row['MovieName']."</td>
						</tr>";
			}
			echo "	</tbody>
				</table>";
		}

		if(isset($_POST['author'])){
			$inds = $_POST['inds'];
			$query = "SELECT Auname as AuthorName
					    from author
					    where author_ranking < all (SELECT author_ranking 
					                               from author 
					                               where industry='".$inds."')";
			$res = mysqli_query($conn,$query);
			echo "<table class='table table-striped'>
					<thead>
						<tr>
							<th>AuthorName</th>
						</tr>
					</thead>
					<tbody>";
			while($row = mysqli_fetch_assoc($res)){
				echo "<tr>

						<td>". $row['AuthorName']."</td>
						</tr>";
			}
			echo "	</tbody>
				</table>";
		}
	?>
</div>
</body>
</html> 