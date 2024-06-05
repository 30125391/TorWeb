import java.sql.*;
import java.util.Random;

public class signUp {
    public static void main(String[] args) {

        if (args.length < 3) {
            //System.out.println("Usage: java SignUp <db_File> <userInputPassword> <username>");
            return;
        }

        String dbFile = args[0];
        String userInputPassword = args[1];
        String username = args[2];

        // JDBC URL using the provided database file path
        String url = "jdbc:ucanaccess://" + dbFile;
        try {
            // Load the JDBC driver
            Class.forName("net.ucanaccess.jdbc.UcanaccessDriver");

            // Establish a connection
            try (Connection connection = DriverManager.getConnection(url)) {
                // Prepare and execute a query to insert user details
                String sql = "INSERT INTO userDetails (ID, Password, DOB, Alias, FirstName, LastName) VALUES (?, ?, ?, ?, ?, ?)";
                try (PreparedStatement statement = connection.prepareStatement(sql)) {

                    // Generate a random ID
                    Random rnd = new Random();
                    int ID = 100000 + rnd.nextInt(900000);

                    // Set values for the prepared statement
                    statement.setInt(1, ID);
                    statement.setString(2, userInputPassword);
                    statement.setString(3, ""); // Set DOB to empty
                    statement.setString(4, username); // Set Alias to the username
                    statement.setString(5, ""); // Set FirstName to empty
                    statement.setString(6, ""); // Set LastName to empty

                    // Execute the update
                    int rowsAffected = statement.executeUpdate();
                    if (rowsAffected > 0) {
                        System.out.println("User details inserted successfully.");
                        // Output the ID in the expected format
                        System.out.println("ID: " + ID);
                    } else {
                        System.out.println("User details insertion failed.");
                    }
                } catch (SQLException e) {
                    System.out.println("Error executing query: " + e.getMessage());
                }
            } catch (SQLException e) {
                System.out.println("Connection error: " + e.getMessage());
            }
        } catch (Throwable e) {
            System.out.println("Error loading JDBC driver: " + e.getMessage());
        }
    }
}
