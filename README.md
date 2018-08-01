# todo-demo
A demonstration todo app using Laravel and Vue

* user authentication
* access allowed only to tasks owned by current user
* REST api authenticated using sessions
* a calendar view showing tasks due in the current month

# to build

1. clone repository
2. copy .env.example to .env in project root
3. create a mysql database and add connection details to .env
4. composer install
5. php artisan key:generate
6. php artisan migrate
7. npm install
8. npm run dev

# to serve locally
1. php artisan serve
2. go to http://localhost:8000

You will need to register to use the application - the email doesn't need to be genuine