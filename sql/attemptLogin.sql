/* Select customers where the username and password match those passed as parameters */
SELECT *
FROM final_users
WHERE
	username = :username AND
	password = :password
	