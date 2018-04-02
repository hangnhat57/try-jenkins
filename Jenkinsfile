// Powered by Infostretch 

timestamps {

node () {

	stage ('freestyle - Checkout') {
 	 checkout([$class: 'GitSCM', branches: [[name: '${sha1}']], doGenerateSubmoduleConfigurations: false, extensions: [], submoduleCfg: [], userRemoteConfigs: [[credentialsId: '6dabc485-5311-4d51-bb63-df3f697a5ecb', url: 'https://github.com/hangnhat57/try-jenkins.git']]]) 
	}
	stage ('freestyle - Build') {
 	
// Unable to convert a build step referring to "org.jenkinsci.plugins.github.pullrequest.builders.GitHubPRStatusBuilder". Please verify and convert manually if required.		// Shell build step
sh """ 
echo "hello" 
 """ 
	}
}
}