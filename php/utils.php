<?php

$PRIVATE_KEY="-----BEGIN RSA PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCNTHEmnSClTVKV6vy6CrEZjkw8DGLQpsc/TbeTlmP3BvQPtQFZvnjDrZxeIONfzdkoJsiOXfh5rnJIBpZlYoLzwZZ7V54LemE70PNeAM1afx55fofscXe/u6RGrpKx+cI2t0Y8wQAFOA6TV3pl3P3G60Yw0q/P5LfHLtqW1Cr50knSTe9cdCjfVFQtSfCBETdYoy8dPMUUt4pDDQZw6aPI46BPKU+E7vbiW2TtdnOhJJGa+nWIzb5fXai4M/+BGMFAt/FIv70uWO5jvUCGNcFaoMw0C9BJnR2uBFfk+tO/J2IxGkN5Bf03dDT2B5AevAprj/LDBI2/GVt1OEr/x0WjAgMBAAECggEAaYYdOuk96DXG54+HDqnNeXh8Fpxpb8oeI3i3ENHP9jyLKO/VAmDtb7XIgcOuC26ALyxHu4sSdk2Bq6i/yRe5FLIO4C6fKZNL6pAyMJIIyv0ElVeZy0syU06fcOoPRDtyf8p/+f9pNHyY5hD+p/RS0qwCz5OJGYmGdorXVK0/KzJzBX+rXLv/L/zkGwN3bPi7Kj/O7I6esCXiEOCexZBphYc/DEFnGAqBlgw6aXiGu6bJW1yXO5kBcGEh5BAuCYe18Y+x9/e+cyFPEgDYwICSu0/9eBDqC/jOkr4bCEvCMi4mbdEc3ZVf/Yz7v1nY7NE2IyVz0D1BmbnYIG9QHT4YAQKBgQDXcDAmQ3zo5y8b70ULyno4ZHnp0a5JhCXeKSEpN2QOCF6KgccOsK6PRWmM/Vt7olKLz/spXM8YtNBlmaMqQcM28ach+Po6P5E9wnvUcr+Ado4GXHN5X5IH4r+Hr1QpTZiS4IgHJqCSKqTwuu4yPmScTC83IxeOF41Dlm123eb4QQKBgQCn5tSjX48/Z43OwTOUCUWxXCCaVzO05afBEkqvFJ6yLLlIP10hewhIpVMrbZ8GyUX8vlRPef19sr1e4GAIPvgl1dtQpwG7nbApin406z4/6H6ZnPBItCI2HuPUx2Yr6zzVsjHwbJQg4zuX2pQCXv3JEWzUyO1S4xKnLFTo/RAk4wKBgC9nC/EfYFiOpZrr5rFVd9b4pKqB7GtYnExpmFZNTcKYrNSlAXuF/KKhjzvqczqc2LTSqlzLgvXYsxHn4DLoDWAFg9TBx60RV4/TPxPbu680ZsOXjADkumjpx2K/fTEpVazbopKQOTxwDaK6Prbna5PIX4suOXyWSgrZCnThFnUBAoGBAIiYRWPISVzW3UpYaaLEzFsXTTrjOKCxuYFcZT/8sYLY2b/KNPUZB8s6HOiW3SqDMpoFKcgiwbSyZle6iMYMnIsDadI6nDFLf1a8YiKhQ1pwxhYo1F8BlVecV9PyiM+wKCTePLyRSQ1ccE4BOCqZpzQeJgESmei17aXtbgLCZpDrAoGBAJS8eNopYaXMdo6FBO+ZD4a7Al+6K/2430ZBbl6zQve9GqyZpLskykqB+sIA7T8miKoSRMBEQs1B2x02WhYBZZiS/PMDg9Iq1HEQkLBJKGf4DdbIEhiF1EErUpyb3Bf9l1Axv72L+/f47s/axHPpskeu0la5/XkdX0kJP2kZB1tk
-----END RSA PRIVATE KEY-----";

$PUBLIC_KEY="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAhc3T9+a7fr3u568Sra4mne86XJcLOHq2lyYa0gWMZ27f1eLTAfIbDO1lQ2LeWdEMEnxe/AIue49s8LKyycfZPDuj2BJVfj8ey/1dG+q7pdUda6i7j/fWFXdCgXKAM6o04g83hK3VdeC8hkMwojxGKm2XEgWsW1y7XxlhEKH6FH0UL/342ycDaHcNppIPmOtYlucjeq0Fhi2g7qhyvvEHyn754mTy9bXm7ZnED71mPcVb/Un6hsxJxTQ/4j476WR08G/eHbBiVKiQBxnobu4BkckMd8zT/e7RyvtcdJkt9Aw8XPLh8pUl5WcvKvEEb2UdIw0uY3EnlGHVMUrCIweMLwIDAQAB
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
