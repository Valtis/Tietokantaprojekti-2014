
public class Rekursio {
	public static int kertoja = 0;
	
	public static void metodi() {
		kertoja++;
		System.out.println("Minua on kutsuttu " + kertoja + " kertaa!");
		metodi();
	}

	public static void main(String [] args) {
		metodi();		
	}

}