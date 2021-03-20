# PHP-Daemon

Simple Daemon-Class to require another file which gets executed every second.

## Getting Started

### Prerequisites

* PHP installed
* (Optional) Cron to check daemon alive

### Installing

Clone project somewhere needed

```
git clone https://lab.blax.at/justsomexanda/php-daemon daemon
```

Adjust executed file (daemon-execute-code.php)

```
(for example with nano)
nano daemon-execute-code.php
```

## Deployment

After adjusted code-file you can start the daemon

```
php daemon.class.php
```

## Authors

* **Alexander Blasl** - *Initial work* - [justsomexanda](https://github.com/justsomexanda)


## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone who is willing to help
