<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/test.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/test.yml/badge.svg" alt="Test Status">
</a>
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/deploy.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/deploy.yml/badge.svg" alt="Deploy Status">
</a>
<br>
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/tests.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/raw/badges/main/coverage.svg" alt="Code Coverage">
</a>
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/insights.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/raw/badges/main/insights-code.svg" alt="Code Quality">
</a>
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/insights.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/raw/badges/main/insights-architecture.svg" alt="Code Architecture">
</a>
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/insights.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/raw/badges/main/insights-complexity.svg" alt="Code Complexity">
</a>
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/insights.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/raw/badges/main/insights-style.svg" alt="Code Style">
</a>
</p>

## About Budget Tracker

## Setup

Use the following commands to setup the project:

```shell
chmod +x setup.sh
./setup.sh
```

Optionally you can follow the official [Laravel installation guide](https://laravel.com/docs/10.x/installation).

## Usage

Run the following command to start the development server and other services such as database, redis etc.:

```shell
sail up -d
```

To stop the development server and other services, run the following command:

```shell
sail down
```

or to stop the development server, run the following command:

```shell
sail stop
```

To start the frontend development server run the following command:

```shell
sail npm run dev
```

Please refer to official Laravel documentation for more information about [Sail](https://laravel.com/docs/10.x/sail).

### Documentation

Documentation is available on `/docs`.

API Documentation is available on `/docs/api`. 

#### Generating documentation

Documentation is generated using [phpDocumentor](https://www.phpdoc.org/). To generate documentation, run the following command:

```shell
./generate_docs.sh
```

API Documentation is generated automatically thanks to Scramble.

## License

Copyright (C) 2023 Damian Chojnacki

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.

If your software can interact with users remotely through a computer network, 
you should also make sure that it provides a way for users to get its source. 
For example, if your program is a web application, its interface could display 
a “Source” link that leads users to an archive of the code. There are many ways 
you could offer source, and different solutions will be better for different 
programs; see section 13 for the specific requirements.
