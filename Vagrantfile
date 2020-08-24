# -*- mode: ruby -*-
# vi: set ft=ruby :

# A Vagrantfile to set up three VMs, two webserver and a database server,
# connected together using an internal network with manually-assigned
# IP addresses for the VMs.

Vagrant.configure("2") do |config|

  #Use Ubuntu 20.04 LTS for all VM's
  config.vm.box = "ubuntu/bionic64"

  # 1st webserver VM name
  config.vm.define "web-server-user" do |webserver_user|

  # This will be the host name of the guest virtual machine.
    webserver_user.vm.hostname = "web-server-user"

    #Foward port 80 to 8080 to loopback on host
    webserver_user.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

    # Create a private network, which allows host-only access to the machine
    # using a specific IP.
    webserver_user.vm.network "private_network", ip: "192.168.33.10"

    #Share HTML folder to first VM
    webserver_user.vm.synced_folder "./public/user", "/var/www/html/"

    #Use virtualbox as hypervisor
    webserver_user.vm.provider "virtualbox" do |vb|
    
        # this line to setup the name of our virtual machine as it will appear in virtual box.
        vb.name = "web-server-user"
        
        # don't display the VirtualBox GUI when booting the machine
        vb.gui = false

        # 1GB RAM
        vb.memory = "1024"
    end

    # Shell script to update packages and install webserver
    webserver_user.vm.provision "shell", inline: <<-SHELL
      echo "user web server has started"
      apt-get update && apt full-upgrade -y
      apt-get install -y apache2
    SHELL
  end

  # 2nd virtual machine 
  config.vm.define "db-server" do |dbserver|
    dbserver.vm.hostname = "db-server"

    dbserver.vm.network "private_network", ip: "192.168.33.20"

    dbserver.vm.provider "virtualbox" do |vb|
        vb.name = "db-server"
        vb.gui = false
        vb.memory = "1024"
    end
    
    dbserver.vm.provision "shell", inline: <<-SHELL
      echo "database server has started"
      apt-get update && apt full-upgrade -y
      apt-get install -y mysql-server
    SHELL

   end

  config.vm.define "web-server-admin" do |webserver_admin|
    webserver_admin.vm.hostname = "web-server-admin"
    webserver_admin.vm.network "private_network", ip: "192.168.33.15"
    
    #Share HTML folder to first VM
    webserver_user.vm.synced_folder "./public/user", "/var/www/html/"

    webserver_admin.vm.provider "virtualbox" do |vb|
      vb.name = "web-server-admin"
      vb.gui = false
      vb.memory = "1024"
    end

    webserver_admin.vm.provision "shell", inline: <<-SHELL
      echo "admin web server has started"
      apt-get update && apt full-upgrade -y
      apt-get install -y apache2
    SHELL

   end
end
