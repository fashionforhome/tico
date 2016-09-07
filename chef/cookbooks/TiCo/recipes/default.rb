#
# Cookbook Name:: TiCo
# Recipe:: default
#
# Copyright 2016, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

#
# Create application config
#
template "#{node['TiCo']['rootFolder']}/.env" do
	source ".env.erb"
	mode "0644"
	owner "root"
	group "root"
end

#
# Create jira config
#
template "#{node['TiCo']['rootFolder']}/config/jira.php" do
	source "config/jira.php.erb"
	mode "0644"
	owner "root"
	group "root"
end

#
# Create printer config
#
template "#{node['TiCo']['rootFolder']}/config/printer.php" do
	source "config/printer.php.erb"
	mode "0644"
	owner "root"
	group "root"
end