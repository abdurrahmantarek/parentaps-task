# Parent APS Task Readme

This readme provides a simple guide to understand and set up the Parent APS Task project.

## Task Description

The Parent APS Task project involves working with data from two providers, DataProviderX and DataProviderY. It includes setting up the project, configuring environment variables, and running test cases.

## Installation

Follow these steps to install the project:

1. Clone the project repository:

   ```
   git clone git@github.com:abdurrahmantarek/parentaps-task.git
   ```

2. Navigate to the project directory:

   ```
   cd parentaps-task
   ```

3. Create an environment configuration file by copying the example file:

   ```
   cp .env.example .env
   ```

## Environment Configuration

In the `.env` file, you'll find important configuration keys:

- `APP_PORT`: Set the application port (default is 9090). You can change it if needed.

- `APP_DATA_PROVIDER_X_JSON_PATH`: Path to DataProviderX JSON file in storage folder.

- `APP_DATA_PROVIDER_Y_JSON_PATH`: Path to DataProviderY JSON file in storage folder.

## Starting the Project

To start the project, use the following command:

```
vendor/bin/sail up -d
```

## Data Providers File Paths

The data provider files can be found at the following paths within the project:

- DataProviderX: `storage/app/DataProviders/DataProviderX.json`
- DataProviderY: `storage/app/DataProviders/DataProviderY.json`

## Running Test Cases

To run test cases for the project, use the following command:

```
vendor/bin/sail php artisan test
```
