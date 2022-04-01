// See https://www.opendevstack.org/ods-documentation/ for usage and customization.

@Library('ods-jenkins-shared-library@4.x') _

odsComponentPipeline(
  imageStreamTag: 'ods/jenkins-agent-base:4.x',
  branchToEnvironmentMapping: [
    'master': 'dev',
    // 'release/': 'test'
  ]
) { context ->
  odsComponentStageImportOpenShiftImageOrElse(context) {
    stageBuild(context)
    stageUnitTest(context)
    /*
    * if you want to introduce scanning, uncomment the below line
    * and change the type in metadata.yml to 'ods'
    *
    * odsComponentStageScanWithSonar(context)
    */
    odsComponentStageBuildOpenShiftImage(context)
  }
  odsComponentStageRolloutOpenShiftDeployment(context)
}

def stageBuild(def context) {
  stage('Build') {
    // copy any other artifacts, if needed
    // sh "cp -r build docker/dist"
    // the docker context passed in /docker
  }
}

def stageUnitTest(def context) {
  stage('Unit Test') {
    // add your unit tests here, if needed
  }
}

