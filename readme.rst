
###################
Meetup API
###################


### Register API

```/participants POST``` 

1. Name
2. Age
3. D.O.B (JS `Date` object)
4. Profession (can be `Employed`/`Student`)
5. Locality
6. Number of Guests (0-2)
7. Address (multiline input upto 50 characters)

It takes this data to register a participant and stores in the database and return success or failure basis the execution.



###  List API

```/participants GET```

This API should return the list of participants registered. You can also look at building pagination to support a long list


###  Update API

```/participants PUT```

This API will help us update the data for a certain participant.