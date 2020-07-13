# Pharmacy Finder Api

Used Laravel and Homestead to create an api with a single-point api with route '/api/pharmacies/{lat}/{long}'.
This point will locate the closest pharmacy in the database to the coordinates provided.

The nearest pharmacy will be the nearest -driving distance-, not geolocation distance, since driving distance is more desirable information to a user. Also, longitudes can be trickier to calculate, since they have no consistent measurement. There are different methods for calculating those distances, but as I said before, no one is walking in a straight line to the pharmacy. My neighbor Mark said my next door neighbor doesn't like people walking across his property.

Mark also wants to install French drains around my house. He's very nice and gets bored. He also walks around the neighborhood in flannel pajama pants and a wide-open, button down, plaid shirt -in June- to offer to fix everyone's cars, air conditioners, or pets. Mark is a great guy.

I used the Google Distance Matrix Api to calculate driving distance. Their Api returns distance as a numeric value in meters and a string to dispaly the units of measurements you want to display. The numeric meters are used to calculate nearest distance, but the text is returned in the response to our user.

Commands to run once the VM is running:
`php artisan migrate`
`php artisan db:seed`

The database should now be populated and usable to the API.
