# LawnStarter's Star Wars App

## Short Answer Questions

1. What are you hoping to find in your next position that would make us the right next step in your carrer?

Answer:
> The opportunity to work in international projects with multi cultural backgrounds.

2. What have you learned so far about us that has excited you?

Answer:
> The company recently had its first profitable year; some key people in the company has experience from Brazil, my home country.

3. Have you worked in an environment where developers own delivering features all the way to production? We have QA (Quality Assurance) and a Product Operations team, however they exit to provide support to engineers. Are you comfortable going to a place where the quality buck stops with the engineers and you have the ability to deploy and observe your own code in production?

Answer:
> Yes, I have this experience since the beginning of my journey as a Full Stack Web Developer. I often am responsible to shiping the code, specially on the backend and the infra structure (AWS or DigitalOcean). However, in order to maintain quality, it is important to develop strategies such as unit testing and static analysis on the code that must be run before deployments. That also minimizes the risks of owning the entire process of developing and shipping to production.

4. What is the next technology or subject you are hoping to learn about?

Answer:
> There are many subjects I would like to learn or dive deeper into. However, I have been looking into the Rust programming language and Cyber Security.

## Running the Application

It is important to follow the steps in order.

1. After cloning this repo, go into the project root directory using a Terminal:

```console
$ cd sw-app
```

2. Create `.env` file from `.env.example` file:

```console
$ cp .env.example .env
```

3. Change the `APP_PORT` or `FORWARD_DB_PORT` inside `.env` file if you must

4. Install dependencies using a temporary Docker container:

```console
$ docker run -it --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/opt" \       
    -w /opt \         
    laravelsail/php84-composer:latest \
    composer install
```

5. Now you can use [Laravel Sail](https://laravel.com/docs/12.x/sail) to run the application inside Docker containers:

```console
$ ./vendor/bin/sail up -d
```

6. Run migrations:

```console
$ ./vendor/bin/sail artisan migrate
```

7. Run NPM commands:

```console
$ ./vendor/bin/sail npm install
```

```console
$ ./vendor/bin/sail npm run dev
```

8. Application will be available at `http://localhost:${APP_PORT}`

Hope you like it!

### Runing the Queue Worker

It's neccessary to run the queue worker on a separate terminal for some features to work:

```console
$ ./vendor/bin/sail artisan queue:work 
```

## Running Tests and Measuring Code Coverage

In order to run tests with PHPUnit:

```console
./vendor/bin/sail artisan test
```

- You can add the `--coverage` argument on the command above to measure code coverage with PCOV driver;
- You can add the `--parallel` argument on the command above to run the tests in parallel. 

## Static Analysis with PHPStan

In order to run PHPStan's static analysis against the code, run:

```console
$ ./vendor/bin/sail php vendor/bin/phpstan
```

This will take into account the configuration in `phpstan.neon` file.

## Formatting Code with Laravel Pint

You can leverage PHP CS Fixer through Laravel Pint to check if code styling is following [PSR-12](https://www.php-fig.org/psr/psr-12/) standards:

```console
./vendor/bin/sail php vendor/bin/pint --test --preset psr12
```

By removing the `--test` argument on the command above, the code will be  actually formatted in PSR-12 if code is not following the standard.

## Feedback

1. What parts of this did you enjoy?

Answer:
> Backend and using Laravel Sail for Docker containers; static analysis, testing, code coverage...

2. What parts of this did you dislike?

Answer:
> I don't like the frontend as much as the other parts.

3. Any other comments/feedback?

Answer:
> No. That's it 🙂
