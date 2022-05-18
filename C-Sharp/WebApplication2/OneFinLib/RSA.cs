namespace Crypto
{
    using System;
    using System.Text;
    using System.Security.Cryptography;
    using System.Linq;

    public static class RSA
    {
        public static string SignRSASHA1(string data, string privateKeyXML)
        {
            var rsa = new RSACryptoServiceProvider();
            rsa.FromXmlString(privateKeyXML);

            var dataBytes = Encoding.UTF8.GetBytes(data);
            var signedData = rsa.SignData(dataBytes, CryptoConfig.MapNameToOID("SHA1"));
            var hexString = BitConverter.ToString(signedData);
            hexString = hexString.Replace("-", "");
            return hexString;
        }

        public static bool VerifyRSASHA1(string data, string signature, string publicKeyXML)
        {
            var rsa = new RSACryptoServiceProvider();
            rsa.FromXmlString(publicKeyXML);

            return rsa.VerifyData(Encoding.UTF8.GetBytes(data), CryptoConfig.MapNameToOID("SHA1"),
                StringToByteArray(signature));
        }

        public static byte[] StringToByteArray(string hex)
        {
            return Enumerable.Range(0, hex.Length)
                             .Where(x => x % 2 == 0)
                             .Select(x => Convert.ToByte(hex.Substring(x, 2), 16))
                             .ToArray();
        }

    }
}