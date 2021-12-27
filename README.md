# TYPO3 Extension `slub_profile_events`

[![TYPO3](https://img.shields.io/badge/TYPO3-11-orange.svg)](https://typo3.org/)

SLUB profile service event extension for TYPO3.

## 1 Usage

### 1.1 Installation using Composer

The recommended way to install the extension is using [Composer][1].

Run the following command within your Composer based TYPO3 project:

```
composer require slub/slub-profile-events
```

## 2 Administration corner

### 2.1 Release Management

News uses [semantic versioning][2], which means, that
* **bugfix updates** (e.g. 1.0.0 => 1.0.1) just includes small bugfixes or security relevant stuff without breaking changes,
* **minor updates** (e.g. 1.0.0 => 1.1.0) includes new features and smaller tasks without breaking changes,
* **major updates** (e.g. 1.0.0 => 2.0.0) breaking changes wich can be refactorings, features or bugfixes.

## 3 API

This extension communicates with another system to provide events. This other system **requires an
authorization with username and password**. Please configure this data at extension configuration.
If you do not have this data, ask the administration of the other system to allow access. This
authorization works for the complete api.

### 3.1 Routes

Please check the routes' configuration. You have to set the matching page (limitToPages). If not the routes will not work properly.

### 3.2 Events

A list of events, you can manipulate with additional parameters.

- **Uri DDEV local:** https://ddev-slub-profile-service.ddev.site/events
- **Uri general:** https://###YOUR-DOMAIN###/events

#### 3.2.1 Extension configuration

- **Uri:** Address or domain to request the data. The uri has to begin with "https://". Another DDEV container can be addressed directly via the container with "https: // ddev - ### YOUR-CONTAINER ### - web" or the domain, if configured "external_links".
- **Argument identifier:** When you request data from this extension to the event api (external extension), you use additional parameters too. These parameters are wrapped with the "argument identifier". The default value is "tx_slubevents_apieventlist". Change only if you know what you do.

#### 3.2.2 Available additional parameter

Additional parameter | Type | Validation | Comment
-------------------- | ---- | ---------- | -------
tx_slubprofileevents_eventlist[category]          | String/ Integer     | 1 | Comma separated list of category ids
tx_slubprofileevents_eventlist[discipline]        | String/ Integer     | 1 | Comma separated list of discipline ids
tx_slubprofileevents_eventlist[contact]           | String/ Integer     | 1 | Comma separated list of contact ids
tx_slubprofileevents_eventlist[showPastEvents]    | Integer (0/ 1)      | 2 | Default is to show events beginning with today
tx_slubprofileevents_eventlist[showEventsFromNow] | Integer (0/ 1)      | 2 | Additional setting for "showPastEvents"
tx_slubprofileevents_eventlist[limitByNextWeeks]  | Integer             | 3 | Set a limit for the next weeks
tx_slubprofileevents_eventlist[startTimestamp]    | Integer (Timestamp) | 4 | Influence the start date, works together with stopTimestamp
tx_slubprofileevents_eventlist[stopTimestamp]     | Integer (Timestamp) | 4 | Influence the stop date, works together with startTimestamp
tx_slubprofileevents_eventlist[sorting]           | String (asc/ desc)  | 5 | Default value is ascending
tx_slubprofileevents_eventlist[limit]             | Integer             | 3 | Limit quantity of result data

**Sanitization**

There is a simple sanitization integrated.

1. **CommaSeparatedStringIds**: Converts each item (separated by comma) in a integer
1. **Checked**: Parameter needs to be "1" to be respected
1. **Integer**: Parameter is converted to an integer
1. **StartAndStopTimestamp**: Both parameter needs to be set as integer
1. **Sorting**: Just works with the key words "asc" and "desc"

### 3.3 Events of a user

A list of events from a given user, you can manipulate with additional parameters.

- **Uri DDEV local:** https://ddev-slub-profile-service.ddev.site/events/user/###USER_ID###
- **Uri general:** https://###YOUR-DOMAIN###/events/user/###USER_ID###

#### 3.3.1 Extension configuration

- **Uri:** Address or domain to request the data. The uri has to begin with "https://". If you connect to another ddev container, please use "https://ddev-###YOUR-CONTAINER###-web".
- **Argument identifier:** When you request data from this extension to the event api (external extension), you use additional parameters too. These parameters are wrapped with the "argument identifier". The default value is "tx_slubevents_apieventlistuser". Change only if you know what you do.

#### 3.3.2 Available additional parameter

You can use the same parameters as "events". Just replace "tx_slubprofileevents_eventlist" against
"tx_slubprofileevents_eventlistuser".

[1]: https://getcomposer.org/
[2]: https://semver.org/

