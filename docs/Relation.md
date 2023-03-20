## Documentation for the Relation Class

The Relation class is used to represent a relationship between the users of the 
app.

1. The **isPending()**
   The code checks the relation table to see if there is a row with a status of
   'P' (presumably meaning "pending") where either from is the first user and to 
    is the second user, or from is the second user and to is the first user. The ? 
    placeholders in the SQL statement are then filled in with the values of $from and $to to prevent SQL injection. 
    If the query returns one row, it means there is already a pending friend request 
    between the two users, and the function returns true after setting an error message. 
    If the query returns zero rows, it means there is no pending friend request, and the 
    function returns false.

2. The **alreadyFriends()**
   The code checks the relation table to see if there is a row with a status of 'F' 
   (presumably meaning "friends") where either from is the first user and to is the 
   second user, or from is the second user and to is the first user. The ? placeholders 
   in the SQL statement are then filled in with the values of $from and $to to prevent 
   SQL injection. If the query returns one row, it means the two users are already 
   friends, and the function returns true after setting an error message. If the query 
   returns zero rows, it means the two users are not friends, and the function returns 
   false.

3. The **request()**
   The code checks if the two users are already friends or if there is already a 
   pending friend request between them. If not, it inserts a row into the relation 
   table with the status 'P' (presumably meaning "pending") and the from and to 
   columns set to the two users' IDs. If the query is successful, the function returns 
   true. If not, it returns false.
4. **block()**
   The code checks if the two users are already friends or if there is already a 
   pending friend request between them. If not, it inserts a row into the relation 
   table with the status 'B' (presumably meaning "blocked") and the from and to 
   columns set to the two users' IDs. If the query is successful, the function returns 
   true. If not, it returns false.
5. **unfriend**()
   The code checks if the two users are already friends. If so, it deletes the row 
   from the relation table where either from is the first user and to is the second 
   user, or from is the second user and to is the first user. If the query is 
   successful, the function returns true. If not, it returns false.
6. **accept()**
   The code checks if there is a pending friend request between the two users. If 
   so, it updates the row in the relation table where either from is the first user 
   and to is the second user, or from is the second user and to is the first user, 
   setting the status to 'F' (presumably meaning "friends"). If the query is 
   successful, the function returns true. If not, it returns false.
7. **cancel()**
   The code checks if there is a pending friend request between the two users. If 
   so, it deletes the row from the relation table where either from is the first 
   user and to is the second user, or from is the second user and to is the first 
   user. If the query is successful, the function returns true. If not, it returns 
   false.
8. **unfriend**()
   The code checks if the two users are already friends. If so, it deletes the row 
   from the relation table where either from is the first user and to is the second 
   user, or from is the second user and to is the first user. If the query is 
   successful, the function returns true. If not, it returns false.
9. **unblock()**
   The code checks if the two users are already blocked. If so, it deletes the row 
   from the relation table where either from is the first user and to is the second 
   user, or from is the second user and to is the first user. If the query is 
   successful, the function returns true. If not, it returns false.
10. **getBlockedUsers()**
    The code checks if the user is blocked by any other users. If so, it returns 
    the list of users. If not, it returns false.
11. **updateRequest()**
    The code checks if there is a pending friend request between the two users. If 
    so, it updates the row in the relation table where either from is the first user 
    and to is the second user, or from is the second user and to is the first user, 
    setting the status to 'F' (presumably meaning "friends"). If the query is 
    successful, the function returns true. If not, it returns false.

    


<hr>

See Also [the code for this class](./relation-code.md)
