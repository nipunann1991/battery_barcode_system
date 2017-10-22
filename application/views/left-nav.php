
	<div class="head" ng-controller="navCtrl">
	  	<div class="title"> 
	  		<md-button type="button" ng-click="toggleNav()" class="md-icon-button navbar-toggle" >
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </md-button>
	  	 {{application_name}} </div>
	  	<div class="user">
	    	<div class="user_img"></div>
		    <ul>
		      	<li class="user_name">{{name}}</li>
		      	<li class="user_role">{{role}}</li>
		    </ul> 
	 	</div>
	</div>
	<div class="body" ng-controller="navCtrl">

		<ul id="accordion">
		    <li ng-repeat="nav in nav_links " class="panel ">
		    	<md-button ng-href="{{nav.page_link}}"  data-toggle="collapse"  data-parent="#accordion" class="md-button md-ink-ripple"  data-target="#nav_{{nav.page_name}}" > 
		      	<i class="{{nav.page_icon}}"></i> {{nav.page_name}} <span class="caret pull-right" ng-if="nav.page_sublinks"></span></md-button> 

		      	<ul class="collapse nav_{{nav.page_name}}" id="nav_{{nav.page_name}}" ng-if="nav.page_sublinks">
			        <li>

						<md-button ng-href="{{subnav.subpage_link}}" ng-repeat="subnav in nav.page_sublinks" > 
					      	- &nbsp; {{subnav.subpage_name}}
					    </md-button> 

			        </li> 
			    </ul> 

		    </li>

		</ul>

	</div> 
