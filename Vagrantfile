# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
  config.vbguest.auto_update = false

  config.vm.box = "bento/ubuntu-20.04"

  config.vm.provision :shell, :path => ".vagrant/bootstrap.sh"
  # Enable config changes to take effect without provisioning
  config.vm.provision :shell, :path => ".vagrant/start.sh", run: "always"


  config.vm.network :private_network, ip: "192.168.4.3"
  config.vm.hostname = "cuttlefish.test"

  config.vm.provider "virtualbox" do |vb|
	vb.name = "cuttlefish"
  end

  config.vm.synced_folder ".", "/vagrant"
  # Enable writing to the logs and cache folder through permissions
  config.vm.synced_folder ".", "/srv/app", owner: "www-data", group: "www-data"
end
