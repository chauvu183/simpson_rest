## About Simpson Rest API
A REST API is created with the following properties:
- The user can authenticate at an endpoint with name and password.
- The combination of name and password is checked on the server side. ¨
- If the input is incorrect, an error is returned. ¨
- After a successful name & password call, the user can call up the following endpoint: ¨
- Exactly 5 quotes with links to images from the Simpsons Api are returned. ¨
- The first quote is retrieved anew in each case, the other 4 come from a database.
- The newly retrieved quote is written to the database and the oldest one is removed from the database.removed from the database.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
