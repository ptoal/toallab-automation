# windows_ovirt_template
This repo contains an Ansible role that builds a Windows VM template from an ISO file on Ovirt/RHV.
You can run this role as a part of CI/CD pipeline for building Windows templates on Ovirt/RHV from an ISO file.

> **_Note:_** This role is provided as an example only. Do not use this in production. You can fork/clone and add/remove steps for your environment based on your organization's security and operational requirements.

Requirements
------------

You need to have the following packages installed on your ansible control machine:

- mkisofs

You need to enable qemu_cmdline hook on your RHV/Ovirt environment, this is required to enable attaching multiple iso files. Follow the instructions documented here:

https://www.ovirt.org/develop/developer-guide/vdsm/hook/qemucmdline.html

Before you can use this role, you need to make sure you have Windows install media iso file uploaded to a iso domain on your RHV/Ovirt environment.

Role Variables
--------------

A description of the settable variables for this role should go here, including any variables that are in defaults/main.yml, vars/main.yml, and any variables that can/should be set via parameters to the role. Any variables that are read from other roles and/or the global scope (ie. hostvars, group vars, etc.) should be mentioned here as well.

Dependencies
------------

A list of roles that this role utilizes, make sure to call this out in requirements.yml file under roles directory or download manually:

- oatakan.windows_template_build

Example Playbook
----------------

Including an example of how to use your role (for instance, with variables passed in as parameters) is always nice for users too:

    - name: create a ovirt windows template
      hosts: all
      gather_facts: False
      connection: local
      become: no
      vars:
        template_force: yes #overwrite existing template with the same name
        export_ovf: no # export the template to export domain upon creation
        local_account_password: ''
        local_administrator_password: ''
        windows_distro_name: 2019_standard # this needs to be one of the standard values see 'os_short_names' var
        template_vm_name: win2019_template
        template_vm_root_disk_size: 30
        template_vm_guest_id: windows_2019x64
        template_vm_memory: 4096
        template_vm_efi: false # you need to install efi file to use this, false should be fine in most cases
        iso_file_name: '' # name of the iso file
        iso_image_index: '' # put index number here from the order inside the iso, for example 1 - standard, 2 - core etc
        iso_product_key: ''
        vm_ansible_port: 5986
        vm_ansible_winrm_transport: credssp
        vm_upgrade_powershell: false # only needed for 2008 R2
        install_updates: false # it will take longer to build with the updates, set to true if you want the updates
        
        ovirt_datacenter: '' # name of the datacenter
        ovirt_cluster: '' # name of the cluster
        ovirt_data_domain: '' # name of the data domain
        ovirt_export_domain: '' # name of the iso domain
        ovirt_iso_domain: '' # this is deprecated as of 4.3 you can omit if not used
        
        template_vm_network_name: ovirtmgmt
        template_vm_ip_address: 192.168.10.95 # static ip is required
        template_vm_netmask: 255.255.255.0
        template_vm_gateway: 192.168.10.254
        template_vm_domain: example.com
        template_vm_dns_servers:
        - 8.8.4.4
        - 8.8.8.8
    
      roles:
        - oatakan.windows_ovirt_template

For disconnected environments, you can overwrite this variable to point to a local copy of a script to enable winrm:

**winrm_enable_script_url:** https://raw.githubusercontent.com/ansible/ansible/devel/examples/scripts/ConfigureRemotingForAnsible.ps1

you can also localize virtio-win and update the virtio_iso_url variable to point to your local url:

**virtio_iso_url:** https://fedorapeople.org/groups/virt/virtio-win/direct-downloads/archive-virtio/virtio-win-0.1.173-2/virtio-win.iso

License
-------

MIT

Author Information
------------------

Orcun Atakan
