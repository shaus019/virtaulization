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

    # Foward port 80 to 8080 to loopback on host
    webserver_user.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

    # Create a private network, which allows host-only access to the machine
    # using a specific IP.
    webserver_user.vm.network "private_network", ip: "192.168.33.10"

    # This following line is only necessary in the CS Labs
    webserver_user.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]

    # Use virtualbox as hypervisor
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
      apt-get update
      
      apt-get install -y apache2 php libapache2-mod-php php-mysql
      # Change VM's webserver's configuration to use shared folder.
      cp /vagrant/conf/user.conf /etc/apache2/sites-available/
      # activate website configuration
      a2ensite user
      # disable the default website provided with Apache
      a2dissite 000-default
      # Reload the webserver configuration, to pick up our changes
      systemctl reload apache2

    SHELL
  end

  # database servers VM name
  config.vm.define "db-server" do |dbserver|

    # This will be the host name of the guest virtual machine.
    dbserver.vm.hostname = "db-server"

    # Create a private network, which allows host-only access to the machine
    # using a specific IP.
    dbserver.vm.network "private_network", ip: "192.168.33.20"

    # This following line is only necessary in the CS Labs
    dbserver.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]


    # Use virtualbox as hypervisor
    dbserver.vm.provider "virtualbox" do |vb|
        
        # this line to setup the name of our virtual machine as it will appear in virtual box.
        vb.name = "db-server"
        
        # don't display the VirtualBox GUI when booting the machine
        vb.gui = false

        # 1GB RAM
        vb.memory = "1024"
    end
    
    # Shell script to update packages and install database server
    dbserver.vm.provision "shell", inline: <<-SHELL
      echo "database server has started"
      apt-get update

      # We create a shell variable MYSQL_PWD that contains the MySQL root password
      export MYSQL_PWD='insecure_mysqlroot_pw'

      # If you run the `apt-get install mysql-server` command
      # manually, it will prompt you to enter a MySQL root
      # password. The next two lines set up answers to the questions
      # the package installer would otherwise ask ahead of it asking,
      # so our automated provisioning script does not get stopped by
      # the software package management system attempting to ask the
      # user for configuration information.
      echo "mysql-server mysql-server/root_password password $MYSQL_PWD" | debconf-set-selections 
      echo "mysql-server mysql-server/root_password_again password $MYSQL_PWD" | debconf-set-selections

      # Install the MySQL database server.
      apt-get -y install mysql-server

      # Run some setup commands to get the database ready to use.
      # First create a database.
      echo "CREATE DATABASE todo;" | mysql

      # Then create a database user "webuser" with the given password.
      echo "CREATE USER 'webuser'@'%' IDENTIFIED BY 'insecure_db_pw';" | mysql

      # Grant all permissions to the database user "webuser" regarding
      # the "fvision" database that we just created, above.
      echo "GRANT ALL PRIVILEGES ON todo.* TO 'webuser'@'%'" | mysql
      
      # Set the MYSQL_PWD shell variable that the mysql command will
      # try to use as the database password ...
      export MYSQL_PWD='insecure_db_pw'

      # ... and run all of the SQL within the setup-database.sql file,
      # which is part of the repository containing this Vagrantfile, so you
      # can look at the file on your host. The mysql command specifies both
      # the user to connect as (webuser) and the database to use (fvision).
      cat /vagrant/db-init.sql | mysql -u webuser todo

      # By default, MySQL only listens for local network requests,
      # i.e., that originate from within the dbserver VM. We need to
      # change this so that the webserver VM can connect to the
      # database on the dbserver VM. Use of `sed` is pretty obscure,
      # but the net effect of the command is to find the line
      # containing "bind-address" within the given `mysqld.cnf`
      # configuration file and then to change "127.0.0.1" (meaning
      # local only) to "0.0.0.0" (meaning accept connections from any
      # network interface).
      sed -i'' -e '/bind-address/s/127.0.0.1/0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf

      # We then restart the MySQL server to ensure that it picks up
      # our configuration changes.
      systemctl restart mysql

    SHELL

   end

  # 2nd webserver VM name
  config.vm.define "web-server-admin" do |webserver_admin|
    webserver_admin.vm.hostname = "web-server-admin"
    webserver_admin.vm.network "private_network", ip: "192.168.33.15"

    webserver_admin.vm.network "forwarded_port", guest: 80, host: 8081, host_ip: "127.0.0.1"
    
    # This following line is only necessary in the CS Labs
    webserver_admin.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]

    # Use virtualbox as hypervisor
    webserver_admin.vm.provider "virtualbox" do |vb|

      # this line to setup the name of our virtual machine as it will appear in virtual box.
      vb.name = "web-server-admin"
        
        # don't display the VirtualBox GUI when booting the machine
        vb.gui = false

        # 1GB RAM
        vb.memory = "1024"
    end

    # Shell script to update packages and install webserver
    webserver_admin.vm.provision "shell", inline: <<-SHELL
      echo "admin web server has started"
      apt-get update
      apt-get install -y apache2 php libapache2-mod-php php-mysql
      # Change VM's webserver's configuration to use shared folder.
      cp /vagrant/conf/admin.conf /etc/apache2/sites-available/
      # activate website configuration
      a2ensite admin
      # disable the default website provided with Apache
      a2dissite 000-default
      # Reload the webserver configuration, to pick up our changes
      systemctl reload apache2
    SHELL

   end
end
