---
- hosts: web
  name: Install the apache web service
  become: yes
  tasks:
  - name: install apache
    yum:
        name: httpd
        state: present
  - name: start httpd
    service:
        name: httpd
        state: started 
