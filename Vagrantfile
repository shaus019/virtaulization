# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # This will be the name of the virtual machine, as it is used by vagrant
  # for stdout and logs.
  config.vm.define "web-server" do |vm1|
  # This will be the host name of the guest virtual machine.
    vm1.vm.hostname = "web-server"
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
    vm1.vm.box = "ubuntu/xenial64"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine and only allow access
  # via 127.0.0.1 to disable public access
  # In my own words: Here it only allows the traffic from the host_ip address,
  # which is the loop back address also known as local host.
  # What it means that the only acess to the ports will be from local machine.
    #config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
    vm1.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  # In my words: Here you can share folders between the host,
  # and guest vm. First path is on the host and the 2nd is guest vm.
    #vm1.vm.synced_folder "/html/", "/var/www/html/"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  # In my words: Provider here is the VM software that we will use.
  # The settings are configured in another block, with the block parameter
  # called vb, which we can use to ammend the seetings by setting properties of vb.
    vm1.vm.provider "virtualbox" do |vb|
    # this line to setup the name of our virtual machine as it will appear in virtual box.
        vb.name = "web-server"
  #   # Do (true) or don't(fasle) display the VirtualBox GUI when booting the machine
        vb.gui = false
  #
  #   # Customize the amount of memory on the VM:
        vb.memory = "1048"
    end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Ansible, Chef, Docker, Puppet and Salt are also available. Please see the
  # documentation for more information about their specific syntax and use.
  # In my words: Provisioning is all about getting the software you need to
  # run your application, including any dependencies onto your machine.
  # You can use to provision vm using shell commands, docker, 
  # puppet or any other tool which vagrant supports.
  # Between the SHELL accurance you can use to define the commands that you want to execute'
  # when your machine is being provisioned.
  # First line in the SHELL document is to update the packages and
  # the 2nd line is to install the apche webserver.
  # -y here is important so ubantu can install the package without promting the user.
    #vm1.vm.provision "shell", inline: <<-SHELL
     #   apt-get update
      #  apt-get install -y apache2
    #SHELL

    vm1.vm.provision "shell", run: "always", inline: <<-SHELL
    echo "hello fro the first virtual machine."
    SHELL
   end
  # 2nd virtual machine settings. 
  config.vm.define "db-server" do |vm2|
    vm2.vm.hostname = "db-server"
    vm2.vm.box = "centos/7"

    vm2.vm.network "private_network", ip: "192.168.33.20"

    #vm2.vm.synced_folder "/html/", "/var/www/html/"

    vm2.vm.provider "virtualbox" do |vb|
        vb.name = "db-server"
        vb.gui = false
        vb.memory = "1048"
    end
   # vm2.vm.provision "shell", inline: <<-SHELL
    #    apt-get update
     #   apt-get install -y apache2
    #SHELL

    vm2.vm.provision "shell", run: "always", inline: <<-SHELL
    echo "hello fro the 2nd virtual machine"
    SHELL
   end
end
