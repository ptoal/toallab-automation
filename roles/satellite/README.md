Satellite 6 Install
===================

Role to install Satellite 6.x

Requirements
------------

A valid Red Hat Subscription must exist on the target host with entitlements for Red Hat Satellite.

Role Variables
--------------

TBD: A description of the settable variables for this role should go here, including any variables that are in defaults/main.yml, vars/main.yml, and any variables that can/should be set via parameters to the role. Any variables that are read from other roles and/or the global scope (ie. hostvars, group vars, etc.) should be mentioned here as well.

Dependencies
------------

TBD: A list of other roles hosted on Galaxy should go here, plus any details in regards to parameters that may need to be set for other roles, or variables that are used from other roles.

Example Playbook
----------------

    - hosts: satellite
      roles:
         - { role: ptoal.satellite, mode: satellite }

    - hosts: capsule
      roles:
         - { role: ptoal.satellite, mode: capsule }


License
-------

BSD

Author Information
------------------

TBD: An optional section for the role authors to include contact information, or a website (HTML is not allowed).
