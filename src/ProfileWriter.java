import java.sql.*;

public class ProfileWriter {

    public static void main(String[] args) {
        if (args.length < 7) {
            System.out.println("Insufficient arguments. Usage: java ProfileWriter <dbFile> <userID> <dob> <username> <firstName> <lastName> <bio>");
            return;
        }

        String dbFile = args[0];
        int ID = Integer.parseInt(args[1]);
        String dob = args[2];
        String username = args[3];
        String firstName = args[4];
        String lastName = args[5];
        String bio = args[6];

        // JDBC URL using the provided database file path
        String url = "jdbc:ucanaccess://" + dbFile;

        try {
            // Load the JDBC driver
            Class.forName("net.ucanaccess.jdbc.UcanaccessDriver");

            // Establish a connection
            try (Connection connection = DriverManager.getConnection(url)) {
                System.out.println("Connected to database successfully.");

                // Prepare and execute a query to update user details
                String updateSql = "UPDATE userDetails SET DOB = ?, Alias = ?, FirstName = ?, LastName = ?, BIO = ? WHERE ID = ?";
                System.out.println("SQL update query: " + updateSql);
                try (PreparedStatement updateStatement = connection.prepareStatement(updateSql)) {
                    updateStatement.setString(1, dob);
                    updateStatement.setString(2, username);
                    updateStatement.setString(3, firstName);
                    updateStatement.setString(4, lastName);
                    updateStatement.setString(5, bio);
                    updateStatement.setInt(6, ID);

                    // Execute the update
                    int rowsAffected = updateStatement.executeUpdate();
                    if (rowsAffected > 0) {
                        System.out.println("User details updated successfully.");
                    } else {
                        System.out.println("No user found with ID: " + ID);
                    }
                } catch (SQLException e) {
                    System.out.println("Error executing update: " + e.getMessage());
                }
            } catch (SQLException e) {
                System.out.println("Connection error: " + e.getMessage());
            }
        } catch (Throwable e) {
            System.out.println("Error loading JDBC driver: " + e.getMessage());
        }
    }
}

