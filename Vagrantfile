# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true

  if Vagrant.has_plugin?("vagrant-vbguest")
    config.vbguest.auto_update = false
  end

  config.vm.box = "bento/ubuntu-20.04"
  config.vm.define :cuttlefish
  config.vm.hostname = "cuttlefish.test"
  config.vm.network :private_network, ip: "192.168.4.3"

  config.vm.provider "virtualbox" do |vb|
	vb.name = "cuttlefish"
  end

  config.vm.provision :shell, :path => ".vagrant/bootstrap.sh"
  # Enable config changes to take effect without provisioning
  config.vm.provision :shell, :path => ".vagrant/start.sh", run: "always"


  # Enable writing to the logs and cache folder through permissions
  config.vm.synced_folder ".", "/srv/app"
  config.vm.synced_folder "src/", "/srv/app/src", owner: "www-data", group: "www-data"
  config.vm.synced_folder "data/", "/srv/app/data", owner: "www-data", group: "www-data"
end
