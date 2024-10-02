function openCraft(domain, success) {
    window.$mdBottomSheet.show({
        templateUrl: '/mfm-world/scene/craft/index.html',
        controller: function ($scope) {
            addFormats($scope)

            $scope.domain = domain

            $scope.amount = 1

            $scope.create = function () {
                postContractWithGas("mfm-world", "api/craft.php", {
                    domain: domain,
                    amount: $scope.amount,
                }, function () {
                    showSuccessDialog("Crafted", success)
                }, (error) => {
                    if (error.indexOf("receiver doesn't exist") != -1) {
                        regAddress(domain, $scope.create)
                    }
                })
            }

            function loadRecipe() {
                postContract("mfm-world", "api/recipe.php", {
                    domain: domain,
                }, function (response) {
                    $scope.recipe = response.recipe
                    $scope.$apply()
                })
            }

            function init() {
                loadRecipe()
            }

            init()

        }
    }).then(function () {
        if (success)
            success()
    })
}