[![GoKEV](http://GoKEV.com/GoKEV200.png)](http://GoKEV.com/)

<div style="position: absolute; top: 40px; left: 200px;">

# lightbulb-ansiblered-deck

This project is the "Ansible Red" deck HTML content.  Optionally, a daemon will be started up if you don't exclude tag "phpdaemon"


## Example Playbooks
Here's an example of how you could launch this role and deploy the PHP daemon to start on port `php_port` and also place the php redirect in the main `{{ workshop_web_path }}`` directory:
<pre>
## both of these example tags default to "never" and will not execute
## unless you explicitly call them at launch time. Therefore, the default
## nature of this role will ONLY synch content and not start the PHP web
## service or place the HTML redirect in web root unless run with these tags:

ansible-playbook -i ec2.hosts GoKEV-lab-provision.yml --tags "phpdaemon,phpredirect"
</pre>

Here's an example of how you could launch this role and and not start the PHP daemon (only synch the content).
<pre>
ansible-playbook -i ec2.hosts GoKEV-lab-provision.yml 
</pre>


## Here's an example of the playbook

<pre>
---
- name: Deploy the Ansible Red deck and run it as a daemon
  hosts: myserver

  vars:
    workshop_web_path: /ansible-php-content/
    workshop_image: images/ansible-logo.png
    workshop_name: Ansible Essentials Workshop
    workshop_presenter: Demo McDemoson
    workshop_title: Solution Architect, Red Hat
    workshop_message: my email and contact info
    php_port: 8000

  roles:
    - lightbulb-ansiblered-deck

</pre>


## Stuff still needing to be done
* Inside `index.php` there are variables for the github star and download counts... probably should be converted to vars in defaults or `extra_vars` params
* Certain presenters have requested dynamic ways to exclude certain sections (exclude entire dir `010_topic_that_bores_my_audience`)
* The HTML ID tags can be manually (accidentally) set to the same name.  This has commonly bitten me when duplicating a slide as a starting point and then forgetting to change the ID.  At some point, these should be dynamically generated per slide.  Two slides with the same ID cause an issue where advancing forward / backward can navigate you all the way back to the first instance of the slide and really make an awkward presentation.
    * `<section id="<?=$pretty_html_dir?>">` or something similar would make a more unique and less likely duplicated tag.


## Easter Eggs
* Not implemented, but capable:  Each directory in `html_slides` can have a `labs` directory.  Slides in this dir will automatically be presented as LABS at the end of each section (numbered directory) and presented with a gray intro slide when the deck advances past the topic section.
    * example:  `html_slides/123_some_topic/labs/00_lab1.html`

* Troubleshooting:  See what files are being included by running a dry run:
    * `http://ansible.red/deck-ansible/?dryrun`

* Changing other dynamic aspects of the content via URL:
    * `person=shadd` (if that person has a preferences file, context will switch to it.  This parallels and overrides the variable determined by a FQDN of `shadd.ansible.red` )
    * `labs` :: `http://ansible.red/deck-ansible/?labs` (no value is required - simply passing this empty variable forces labs-only display mode and will not show the deck
    * `nolabs` :: `http://ansible.red/deck-ansible/?nolabs` (no value is required - opposite of `labs`, this variable forces deck-only display mode and will not show the labs
    * without `labs` or `nolabs` the default behavior is to show labs at the end of each section.
    * `force` :: `http://ansible.red/deck-ansible/?force` (no value is required).  This can be used on its own or in combination with labs, nolabs, person as: `?person=shadd&nolabs&force`.  This parameter shows the status on the HTML output to display the mode. Output is something like:  "LAB LIMIT 2 = No Labs, only deck" on the very top white line of the deck throughout the entire presentation.


## Notes
* index.php includes a lot of stuff as dynamic files from the html_slides directory
* Any file or dir inside `html_slides` can be excluded by starting it with an underscore
    * example:  `html_slides/_000_skipping_this_section`
    * example:  `html_slides/001_not_kipping_this_section/_skipping_this_slide.html`

* Lab slides can also include some variables defined by parsing the directory names.  Take a look at this file for a better understanding and see how the `<?=$varible_name?>` php tags are used:
    * `html_slides/080_Tasks/_labs/00_Tasks_Labs.html`
    * all labs (at this point) are committed with underscore prepending the directory name and won't publish until that dir is changed to `labs`.


## Author
  - Adapted by [Kevin Holmes](http://GoKEV.com/) from the original lightbulb workshop deck, split into dynamic individual slides

## Changelog
  - 2018-11-01 This project was first committed November 1, 2018 by [Kevin Holmes](http://GoKEV.com/).
  - 2018-11-02 Added an `index.php` file to deploy to web root, redirecting to `/deck-ansible` directory when called via tag `phpredirect`

