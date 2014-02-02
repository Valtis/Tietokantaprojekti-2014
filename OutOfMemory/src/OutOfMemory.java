
import java.util.ArrayList;


public class OutOfMemory {
    private static ArrayList<Byte []> lista;
  
    public static void main(String[] args) {
        lista = new ArrayList<Byte []>();
        
        while (true) {
            lista.add(new Byte[25000]);
        }      
    }
    
}
