import java.util.Base64;
import java.security.spec.PKCS8EncodedKeySpec;
import java.security.KeyFactory;
import java.security.PrivateKey;
import java.security.Signature;
import org.apache.commons.codec.binary.Hex;
import java.security.spec.X509EncodedKeySpec;

public String generateSignature(String message, String privateKeyInHexString) throws UnsupportedEncodingException, NoSuchAlgorithmException, InvalidKeySpecException, InvalidKeyException, SignatureException {
		// generate RSA PrivateKey object
		byte[] privateKeyBytes = Base64.getDecoder().decode(privateKeyInHexString.getBytes(""UTF-8""));
		PKCS8EncodedKeySpec spec = new PKCS8EncodedKeySpec(privateKeyBytes);
		KeyFactory fact = KeyFactory.getInstance(""RSA"");
		PrivateKey privateKey = fact.generatePrivate(spec);

		// create RSA signature string using private key
		Signature signature = Signature.getInstance(""SHA1WithRSA"");
		signature.initSign(privateKey);
		signature.update(message.getBytes(""UTF-8""));
		byte[] signatureBytes = signature.sign();
		return Hex.encodeHexString(signatureBytes);
	}
	
public boolean verifySignature(String message, String signatureString, String publicKeyInHexString) throws NoSuchAlgorithmException, UnsupportedEncodingException, InvalidKeySpecException, DecoderException, InvalidKeyException, SignatureException {
		// generate RSA PublicKey object
		byte[] publicKeyBytes = Base64.getDecoder().decode(publicKeyInHexString.getBytes(""UTF-8""));
		X509EncodedKeySpec spec = new X509EncodedKeySpec(publicKeyBytes);
		KeyFactory fact = KeyFactory.getInstance(""RSA"");
		PublicKey publicKey = fact.generatePublic(spec);

		// verify RSA signature
		byte[] decodedSignatureString = Hex.decodeHex(signatureString.toCharArray());
		Signature signature = Signature.getInstance(""SHA1WithRSA"");
		signature.initVerify(publicKey);
		signature.update(message.getBytes(""UTF-8""));
		return signature.verify(decodedSignatureString);
	}