function openWorldDeposit(success) {
    openSelectToken(function (domain) {
        window.$mdBottomSheet.show({
            templateUrl: '/mfm-world/scene/deposit/index.html',
            controller: function ($scope) {
                addFormats($scope)

                $scope.domain = domain
                $scope.to_address = "mfm-world"
                $scope.block_to_address = true

                postContract("mfm-wallet", "token/api/tokens.php", {
                    address: wallet.address(),
                }, (response) => {
                    $scope.activeTokens = response.active
                })

                $scope.send = function () {
                    getPin((pin) => {
                        wallet.calcPass(domain, pin, (pass) => {
                            postContractWithGas("mfm-world", "api/token_deposit.php", {
                                address: wallet.address(),
                                domain: domain,
                                amount: $scope.amount,
                                pass: pass,
                            }, (response) => {
                                showSuccessDialog("Deposit successful")
                            })
                        })
                    })
                }
            }
        }).then(function (scene) {
            if (success)
                success(scene)
        })
    })
}