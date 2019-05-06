kickstart-rhv-template
=========

Initiate a kickstart build of a RHEL Virtual Machine, and use it to create a template.

This role's intended use is as an "automated golden image builder".  By running this role on a <interval> basis, the generated RHV/oVirt template will be kept up to date.  The product can be used as a template to quickly build more VMs that are never more than <interval> days old.

Requirements
------------

A working Satellite and RHV/oVirt installation.

Role Variables
--------------

A description of the settable variables for this role should go here, including any variables that are in defaults/main.yml, vars/main.yml, and any variables that can/should be set via parameters to the role. Any variables that are read from other roles and/or the global scope (ie. hostvars, group vars, etc.) should be mentioned here as well.

Dependencies
------------

A list of other roles hosted on Galaxy should go here, plus any details in regards to parameters that may need to be set for other roles, or variables that are used from other roles.

Example Playbook
----------------

Including an example of how to use your role (for instance, with variables passed in as parameters) is always nice for users too:

    - hosts: servers
      roles:
         - { role: username.rolename, x: 42 }

License
-------

BSD

Author Information
------------------

An optional section for the role authors to include contact information, or a website (HTML is not allowed).
