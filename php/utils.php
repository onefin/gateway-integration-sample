<?php

$PRIVATE_KEY="-----BEGIN RSA PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCd6eBTS8W52RbN9ToUZ5ltPoKa0ZAEuKhnh1EVDWEDugHzQUNOtqLOJEFyAnIkPceSLWzepRzgl3+ZN82I6sRL5KkN930MJsDOa4eFUWBLjcOsioZtNMGjf9xnZ85gYrULoFbGF9wfyH8uPnf28eZCfkn0ZyqDglFQpZiKDgv5UmNFAAOAMORFnUaozn8U11UV/wbEiIbh4GFQpdLz/pKm0tHxx6FM3oA5BxDrfYRB5zSthr7VeYAFDUdj8WrB6C1Jq1crrznX6LXVxHXG5wKYRaFeqJM2bNywRT+X05DBbHr5QXqnllVCeBUkFcuEztn6fKEWsu3gj2Zrg54mI9ofAgMBAAECggEAD3szQ9dE3jB7PNvSwtdZQk2DjlwHK39S+ztX5qF2JmBg+pEmYRwkn+MMC3pT6FuqKhmL99PmHdqcZtACtW6Wqf4T2MuvlbZi5pnCIn7U2vNeAJdgEGrApR/O4tBZejeTGj2w5CDIstD8LvNu3WXfthsdcvl+QIBRKn/hkX9JCzsxYEC6L12GplsWKubfxRhCN6+dRffbjbkpLU9I4cLKbRRy5nXBzIYHGA6lgVNUW+qmeCTgnJgmcByQZMxgN3n5e4q9xikVfLnhIhE2oKesn8LIB3y5VC/vdALKwrd75e056F45j5uyXzxzbDYnI+81u08c416gpGFjBh+cgTcaSQKBgQDy/wJkQHYu6VcZHCukJjPH1FG4ePwV9IGtfgqYKRSx3IAWhI7Uycoz4f8pjfZszjM6tu18rDZwDJxeUhWm1s3wAKGLroPgNuCrpfytpsYX7g7QsT0itCVL3M0PkSiGpbYHPESIZJdIjPShs0dxv4Z+8X4+mCiSu9xOPPXao0j5MwKBgQCmXUF1pdJ0f6BnkC4+bL7AxwrxE3FJTH1i9bDbheBZC7Z2nnuv7rSv3idHWfz2ut1b/RRY7vB2t/kJ2OPkmLyRIxj2hlbVl6dDcfK0zmVRfGCALl2pIZtLBVhICCwmim9qjOQBsCjY38ufZwVw/xU1cPQtPjYLfoHzRAEq9DpTZQKBgQDs47HfLgCJBy3D6vSYmC2Ot+vbHQcUGEN7cQ6++/2Sz1WHnj7oLriTD9UDG8SKmhLTQJYRHooLfh/Ky9cTyQEG4naah81EfftVGwJT/+vKVGfZB5CEDn71kBHRBUAu08m7EAP3u6jIL7IlGXOi7oYdpyvdtdSIB+Bj3YYIWXrAhQKBgBTRbKSVOI29fswW3cKQBxrGjZb3UODUQoiEqDoAOb/K2G1ljaLJYzDywsWJ/D6/yX1+YPJ0DAE/KlnSG0p61nXvB2uqCem2jYbCFpYLkeAtiUHhC3VjsDQmGhMBeszj2+dgdBPGAIaLEscCtEqckQHb/aI/u7GahhZz9xVx9G6FAoGBAMHp/xzT3fvL2DBISATVOViheeYV1wK0FjAF4GqrfB8Upo9nGqZhCBfsHqCJlh1ENOlNVK6yf9JEdxXFcD00FTO+QwOb8HBKne5WpviGRrrzbQlpUZX+yBkaD+vT8xvf/TXE5IpZZjqahVVbfyfCnLLQwCVm07iaXr2cf55Hej3o
-----END RSA PRIVATE KEY-----";

$PUBLIC_KEY="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAk1fKrfxZ/hyPGHA5x8j7dBshtoe586uVOjuDKREIyo6yrxvpHu/ycNSXQXzBr6JLK0GKtx4+ewCHZeMhvAdqmUnvTbUjubFI+lAAOVseH1EHLzdQh3w5nUZFYYaF3INclIYKzJNqnYVhqpRdY8amfnmjVW7oFuZghG//TYGfwTS015fmQI/nLb8O8DBL9CBONupTEasD+tJ41PN15JzZ7rGMSQvMFV3QYzo0CNCk6Ya1kVAVFPso3FEDEhVURuLkPBiu1TL6jpnB/z3F2XfVfJQS43blSyJjTZ7+nSUbCu/BOEgit32gscfCYW0bQdpuvaQOW0E009+nQTd04ET8OwIDAQAB
-----END PUBLIC KEY-----";

function curl_post($url, $data = [])
{
    $data_string = json_encode($data);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data_string,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return json_decode($response);
}
function signMessage($message)
{
    global  $PRIVATE_KEY;
    openssl_sign($message, $signature, $PRIVATE_KEY);

    return bin2hex($signature);
}

function verifySignature($message, $signature)
{
    global $PUBLIC_KEY;
    $signature = hex2bin($signature);

    $verify_sign = openssl_verify($message, $signature, $PUBLIC_KEY);
    return $verify_sign;
}
