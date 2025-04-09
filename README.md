# Translation Management System

## Overview

The Translation Management System (TMS) is designed to streamline the management of translations across various modules within an application. It offers a robust interface for managing languages, tags, and translation entries, making it easier to perform CRUD (Create, Read, Update, Delete) operations on translation data. The system also provides APIs to enable users to interact with translations, perform searches, and export data.

## Setup Instructions

### 1. Clone the Repository

Start by cloning the repository to your local machine:

```bash
git clone https://github.com/erratickhan0/translation-mgt.git
cd translation-mgt

2. Install Dependencies
Once inside the project directory, run the following commands to install the required dependencies:

composer install
npm install
cp .env.example .env
php artisan key:generate

3. Set Up Environment Variables
Ensure the environment variables are set correctly and proceed with database migrations and seeding:
php artisan migrate
php artisan db:seed

4. Build the Front-End Assets
Compile the front-end assets using Vite:

npm run build


5. Run the command to generate translation records

php artisan populate:translations count=100000

After initial setup of Project.
Example Axios API Calls
You can execute the following Axios API calls directly from your browser’s console or integrate them into your front-end application.
 Ensure to replace your_generated_token with the actual token obtained after successful login.
 These API calls will demonstrate how to interact with the Translation Management System via its API.

-----------------------------------------------------------------------------------------------------------------

1. Login - Obtain an API token
Authenticate the user and store the access token for future requests:

window.axios.post('api/login', {
  email: 'user@example.com',
  password: 'password'
})
.then(response => {
  localStorage.setItem('token', response.data.access_token);
})
.catch(error => {
  console.error(error);
});



-----------------------------------------------------------------------------------------------------------------

2. Search Translation - Search a  translation

// Example of searching for translations
window.axios.get('api/translations/search', {
  params: {
    query: 'Welcome',  // Search term
    tag: 'web'     // Optional tag slug for filtering (if any)
  },
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Only for web routes
  }
})
.then(response => {
  console.log('Search Results:', response.data);  // Handle search results
})
.catch(error => {
  console.error('Error searching translations:', error.response?.data || error.message);  // Handle error
});


-----------------------------------------------------------------------------------------------------------------


3. View a single translation
window.axios.get('api/translations/1', {
  headers: {
    Authorization: 'Bearer ' + localStorage.getItem('token')
  }
})
.then(response => {
  console.log(response.data);
})
.catch(error => {
  console.error(error);
});

-----------------------------------------------------------------------------------------------------------------


4.Create a new translation
window.axios.post('api/translations', {
  language_id: 1,
  tag_id: 1,
  value: 'Welcome to the site!',
    key:'welcome_to_site'
}, {
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Only for web routes
  }
})
.then(response => {
  console.log('Translation stored:', response.data);
})
.catch(error => {
  console.error('Error storing translation:', error.response?.data || error.message);
});

-----------------------------------------------------------------------------------------------------------------

5.Update a single translation
window.axios.put('api/translations/1', {
  language_id: 1,
  tag_id: 1,
  value: 'Welcome to the site update!!'
}, {
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Only for web routes
  }
})
.then(response => {
  console.log('Translation stored:', response.data);
})
.catch(error => {
  console.error('Error storing translation:', error.response?.data || error.message);
});

-----------------------------------------------------------------------------------------------------------------

6. Export Translations - Export translations to a file
To export all translations in a desired format (such as CSV, JSON), you can use the following API:

window.axios.get('api/translations/export', {
  headers: {
    Authorization: 'Bearer ' + localStorage.getItem('token')
  }
})
.then(response => {
  // Handle file download or display export result
  console.log(response.data);
})
.catch(error => {
  console.error(error);
});
