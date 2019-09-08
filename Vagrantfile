# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "bento/ubuntu-18.04"

  config.vm.provision :shell, :path => "bootstrap/bootstrap.sh"
  # Enable config changes to take effect without provisioning
  config.vm.provision :shell, :path => "bootstrap/start.sh", run: "always"


  config.vm.network :private_network, ip: "192.168.4.3"
  config.vm.hostname = "carbon.test"

  config.vm.provider "virtualbox" do |vb|
	vb.name = "carbon"
  end

  config.vm.synced_folder ".", "/vagrant"
  # Enable writing to the logs and cache folder through permissions
  config.vm.synced_folder ".", "/srv/carbon", owner: "www-data", group: "www-data"
end
