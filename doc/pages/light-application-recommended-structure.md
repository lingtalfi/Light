Light application recommended structure
=============
2019-04-09 -> 2020-07-10




Light is quite an agnostic framework and let you create any web application you want.

However, here is some organization for files in a Light app that I consider good practice.

The main idea is grouping files by plugins, and don't use shortcut names (to make things simpler).


Here are the potential directories of my ideal light web app:



```yaml
/app:
    /config:                                # contains configuration of the app
        /services:                          # contains the services of the light app  
            - Light_MyPlugin.byml           # an example config file
        /data:                              # is reserved for plugins which needs to store their configuration in files. 
            /Light_MyPlugin:                # an example of configuration data directory for a plugin named Light_MyPlugin
        /dynamic:                           # is reserved for dynamic plugins intercommunication 
            /Light_MyPlugin:                # this directory will contain all messages destined to the Light_MyPlugin plugin
                - ...            
    
    /templates:                             # a directory containing templates of the light plugins, and/or templates in general 
        /Light_MyPlugin:                    # the directory containing templates for the Light_MyPlugin plugin
            - ...
    /www:                                   # the web root directory (www stands for generic "world wide web" expression, not for the specific www domain name)
        /plugins:                           # the directory for light plugins web assets
            /Light_MyPlugin:                # the web assets dir for the Light_MyPlugin planet
                /css:                       # an example directory, not part of the recommendation
                    - style.css             # an example file, not part of the recommendation
                        
        /users:                             # anything created by users should be in this directory
            /$userId:                       # anything created by user with identifier $userId should be in this directory
                                            # This include uploaded files, created website roots (www-one, www-two, ...), anything really.                                       
```




The configuration of a plugin is divided in 3 parts:
- services 
- data 
- dynamic


The **services** part contains the static configuration as written by the plugin author,
and which might be changed from time to time by the application maintainer.

Practice revealed that the **data** part contains the configuration of plugins a particular plugin subscribes to.
Those files are sometimes referred to as **nuggets**, as they hold a bit of the configuration of the services.
So for instance, if plugin AAA subscribes to plugin Apple and plugin Banana, we will have a structure that looks like this:


```yaml
/app:
    /config:
        /data:
            /AAA:
                /Apple:
                    - my-apple-conf.byml
                /Banana:
                    - some-banana-conf.byml
``` 

The **dynamic** is fairly new, it's similar to the **data** part as a plugin AAA can send configuration bits to a "recipient" service such
as Apple or Banana for instance. 

The difference is that the recipient plugins will fetch that configuration only when needed (i.e. lazy fetching) rather than
on the app initialization.

Basically, with the **dynamic** directory our idea is to implement the [late service registration system](https://github.com/lingtalfi/Light/blob/master/personal/mydoc/pages/design/late-service-registration.md). 

The writing in this directory is still static, but the fetching is dynamic, hence the name.
















Service configuration organisation
---------------------------
2019-04-09



Light being a service oriented application, we will inevitably have a lot of services subscribing to each others.

And so an interesting question arise when it comes to configuration files: what's the light philosophy for organizing 
subscribing services: do you create sub-directories inside the host service, or does each subscriber service contain all 
its subscriptions directories?

Let me give you an example so that we can understand better the problem.

Imagine we have a service like "kit", which provides a templating solution. The configuration of kit can be stored either
in a database or in babyYaml files. Imagine that we use a babyYaml file storage.
Now imagine that we have another service called "one", which use kit.

And so the question is: how do you organize your files: do you embed everything under a kit root directory, like this:

- /app/config/data/Light_Kit/
    - /Light_One/  
    - /Light_Two/ 
    - ...  
    
Or does each plugin store its own kit data, like this?

- /app/config/data/Light_One/     
    - /kit/     
    - /some_other_service/     
    - ...
- /app/config/data/Light_Two/     
    - /kit/     
    - /some_other_service/     
    - ...     
- ...     



My first intuition was that the second solution was better because it would be more readable for the developer 
to have everything centralized in one place.

But then I re-thought this, and now I believe that the first solution is better for the following reasons:

- the application gets simpler if each plugin handles itself (i.e. no dependency everywhere. In fact, THIS solution is the most centralized from the subscriber's point of view).
- it gets simpler to write packing routines (i.e. scripts that packs the plugin for you, so that you can publish it on github for instance)
- as long as the developer knows the plugin from which originates the data she is looking for, it's not less efficient to have things organized that way.
        And most of the time, the developer knows those kind of things.
        To know the location of the data one's looking, we actually need to answer two questions:
        - Who (i.e. which plugin) is using the host service?
        - What host service (i.e. which plugin) are we using?
        
- on a semantic level, as said previously, the storage could be a database or the files, and so if we had chosen the database, the approach would have been
    that the subscriber plugin would have register its data to the host plugin, and so by analogy it seems logical that the same applies to the file storage:
    the subscriber plugin owns them, and registers them to the host (but it doesn't give them away to the host like this was not a big deal, the subscriber owns the files after all).          
 

So there you have it, this is the light recommended way: each subscriber owns their own file whenever possible (i.e if the host plugin allows it, which should always
be the case if the host plugin author reads this).



