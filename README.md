# Task:
Simple PHP form submission script with frontend validation.

### Create a MySQL DB table with the following requirements and a frontend submission form for storing the data.

Field/column list
```bash
id (bigint 20)
amount (int 10) *
buyer (varchar 255) *
receipt_id (varchar 20) *
items (varchar 255) *
buyer_email (varchar 50) *
buyer_ip (varchar 20)
note (text) *
city (varchar 20) *
phone (varchar 20) *
hash_key (varchar 255)
entry_at (date)
entry_by (init 10) *
```

- *marked columns can be submitted through the mentioned frontend form.
- Buyer_ip should be the user’s browser ip and will be automatically filled up from backend.
- Hash_key is the encrypted string of ‘receipt_id’ and a proper ‘salt’ using sha-512.
- Entry_at is the submission date in local timezone.

### There will be two types of validation process according to the following requirements

(A) frontend validation (with js entirely),
(B) backend validation.

```bash
Amount: only numbers.
Buyer: only text, spaces and numbers, not more than 20 characters.
Receipt_id: only text.
Items: only text, user should be able to add multiple items (use js based interface).
Buyer_email: only emails.
Note: anything, not more than 30 words, and can be input unicode characters too.
City: only text and spaces.
Phone: only numbers, and 880 will be automatically prepended via js in an appropriate manner.
```
### Instructions:
- Create a simple report page where users can see all the submissions and filter it by date range and/ or user id.
- The whole project must be implemented according to MVC and OOP architectures without any readymade PHP frameworks.
- Project should be workable in “xampp/ wamp/ lamp/ mamp” under localhost.
- Sending copy must be a ZIP archive file and it must contain the whole project, including the db file.
- Include a text file with proper instructions for installing and testing the project.




