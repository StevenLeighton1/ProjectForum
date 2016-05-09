Steven Leighton
Adam Bucknell

COS480 Final Project, Spring Semester 2016

Project Forum
-------------------------------------------------------------------------------------------------------------
Description:

This project was designed as a way to create a meaningful application for a database schema while
fully implementing a system that helps users interact with each other in an easy-to-use way.

There are some essential things to note before any features can be understood:
Models:
	Topics: The broad subject where posts can be made. Users can be moderators of topics.
	Posts: The bread and butter of this project. All posts are visible to anyone going to the
		site and can be rated good or bad and be commented on to allow collaboration by
		other users.
	Comments: The essential tool for collaborating on a post in a given topic. These can be voted 
		good or bad as well as a post. 
	Users: They are your everyday people, the average joes, the professors and experts, amateurs,
		anyone who comes across this site. They can make a post, comment, vote on comments/posts,
		subscribe to posts (to come back to later if they want), view others and their own account,
		edit their account information, and potentially moderate certain topics. 

Features:
	Registering - Allows a new user to post/comment/upvote/downvote/subscribe
	Login/Logout - Users can control being logged in or not.
	Account view - A logged in user can go to their account and see their posts/comments/subscriptions
			and delete them and go to each respective post easily. Users may also view other
			users accounts but don't have the same ability of removing their items.
	Submitting A Post - Users can submit a post with a title and some content attached. This post shows
			up under whichever topic they chose to post under.
	Commenting - Users can make a comment on posts, which is their tool to communicate to the author
			of the post. 
	Upvoting - Users that like a particular post OR comment may give it an upvote. This provides other
			users to see what other people think about a certain post/comment. It's a tool for
			the user, besides explicitly commenting, that they like something.
	Downvoting - Similar to upvoting but more towards disliking an idea mentioned.
	Subscribing - When viewing a post, a user can subscribe to it and see that subscription on their 
			personal account page so they can come back without filtering through all posts.
	Sorting - All topics/posts/comments can be sorted with some respective filtering options. 
			Topics:
				Topic Name (Asc)
				Topic Name (Desc)
				Most Posts
				Most Comments
				TopicID
			Posts:
				Post Name (Asc)
				Post Name (Desc)
				Most Upvotes
				Most Comments
				PostID
				Most Recent
			Comments:
				Most Recent
				Oldest
				User (organizes comments by username)
				Most Upvotes
				Most Downvotes
	Searching - The site can be searched with the given field. The results are found by taking the string
			given and searching through the post titles first (for relevancy purposes) then post
			content. For future applications this should have a filtering option like above.
-------------------------------------------------------------------------------------------------------------
HOW TO USE

The system was designed and implemented using WAMPserver. 
Downloaded here: http://www.wampserver.com/en/
The PHP version used is 5.5.30
PHPmyAdmin was used for the database system

It is crucial that you can provide a server with this version of PHP or higher (7.0.0 might be too high due to
deprecated functions, if any are used). 

Steps to run site on local server: 
-Install a server that can work on your machine.  (WAMP in our case)
-Begin the control panel and start at least Apache and MySQL
-Go to your PHPmyAdmin and insert a new database called forum_proj
-Find the Database.sql file in the project folder and import it into the forum_proj database. This should provide
a useful testing environment with some posts/comments/upvotes/downvotes to look around in.
-Go to the htdocs folder found in your WAMP (or other) directory. Copy or place all project files in a folder called 'ProjectForum'.
-Go back to this project folder and find the database.php file in the system folder. 
-Open it and change the credentials for your PHPmyAdmin on line 4
-All set to test! Open the directory in your browser, typically: localhost/ProjectForum/html/index.php