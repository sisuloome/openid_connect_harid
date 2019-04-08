# HarID

A [HarID](https://harid.ee) client implementation for
[OpenID Connect](https://www.drupal.org/project/openid_connect) module.

Current implementation only provides a Single Sign-On (SSO) capability that
could mostly be achieved using the `Generic` client implementation. The main
difference is currently being predefined endpoints and custom scopes. Currently
used scopes are `openid profile email roles`.

Additional capability is automated process for setting user language preference
based on value of `ui_locales` if one is present (the values are set upon each
successful authentication).

# Usage

**NB! Please note that current codebase requires version 8.x-1.0-beta5.
Other versions could have different signatures for hook being used.**

1. Register your service with [HarID]() using
[this](https://harid.ee/en/pages/dev-info) guide
  1. The callback redirect URL is SITE-BASE-URL/openid-connect/harid
1. Activate the module and enable the **HarID** client
  1. Client configuration and management is made in the admin section. You could
  use admin/config/services/openid-connect as a shortcut

# TODO

* Use `roles` scope to automatically manage additional local roles based on ones
provided by the Identity Provider.
* It might be a good idea to use `.well-known/openid-configuration` and
extract values from it directly instead of just having them hard-coded.
* It could be useful to allow switching between live and test HarID instances.
Though it could raise issues in certain cases. Another possibility is to provide
two different clients with one of those being based on top of the other with
different endpoint settings.
