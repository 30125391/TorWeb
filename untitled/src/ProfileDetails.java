import java.sql.*;

public class ProfileDetails {

    public static void main(String[] args) {
        if (args.length < 2) {
            System.out.println("Insufficient arguments. Usage: java ProfileReader <dbFile> <userID>");
            return;
        }

        String dbFile = args[0];
        int ID = Integer.parseInt(args[1]);

        // JDBC URL using the provided database file path
        String url = "jdbc:ucanaccess://" + dbFile;

        try {
            // Load the JDBC driver
            Class.forName("net.ucanaccess.jdbc.UcanaccessDriver");

            // Establish a connection
            try (Connection connection = DriverManager.getConnection(url)) {
                System.out.println("Connected to database successfully.");

                // Prepare and execute a query to retrieve user details
                String sql = "SELECT DOB, Alias, FirstName, LastName, BIO FROM userDetails WHERE ID = ?";
                System.out.println("SQL query: " + sql);
                try (PreparedStatement statement = connection.prepareStatement(sql)) {
                    statement.setInt(1, ID);

                    // Execute the query and retrieve the result set
                    ResultSet resultSet = statement.executeQuery();

                    if (resultSet.next()) {
                        // Extract user details
                        String dob = resultSet.getString("DOB"); // Date of Birth
                        String alias = resultSet.getString("Alias");
                        String firstname = resultSet.getString("FirstName");
                        String lastname = resultSet.getString("LastName");
                        String bio = resultSet.getString("BIO");

                        // Print user details to the standard output
                        System.out.println(dob);
                        System.out.println(alias);
                        System.out.println(firstname);
                        System.out.println(lastname);
                        System.out.println(bio);
                    } else {
                        System.out.println("No user found with ID: " + ID);
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

