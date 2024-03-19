import java.sql.*;

public class example {
    public static void main(String[] args) {
        if (args.length != 3) {
            System.out.println("Usage: java Example <db_file> <id> <password>");
            return;
        }

        String dbFile = args[0];
        int userInputID = Integer.parseInt(args[1]);
        String userInputPassword = args[2];

        System.out.println("Database file: " + dbFile);
        System.out.println("User ID: " + userInputID);
        System.out.println("User password: " + userInputPassword);

        // JDBC URL using the provided database file path
        String url = "jdbc:ucanaccess://" + dbFile;

        try {
            // Load the JDBC driver
            Class.forName("net.ucanaccess.jdbc.UcanaccessDriver");

            // Establish a connection
            try (Connection connection = DriverManager.getConnection(url)) {
                System.out.println("Connected to database successfully.");
                // Prepare and execute a query to check ID and password validity
                String sql = "SELECT * FROM userDetails WHERE ID = ? AND Password = ?";
                System.out.println("SQL query: " + sql);

                try (PreparedStatement statement = connection.prepareStatement(sql)) {
                    statement.setInt(1, userInputID);
                    statement.setString(2, userInputPassword);

                    ResultSet resultSet = statement.executeQuery();
                    boolean authenticated = false;


                    while (resultSet.next()) {
                        int storedID = resultSet.getInt("ID");
                        String storedPassword = resultSet.getString("Password");

                        if (userInputID == storedID && userInputPassword.equals(storedPassword)) {
                            authenticated = true;
                            System.out.println("User authenticated!");
                            break;

                        }
                    }
                    if (authenticated) {
                        // If a record is found, authentication successful
                        System.out.println("Authentication successful.");
                    } else {
                        // If no record found, authentication failed
                        System.out.println("Authentication failed.");
                    }


                } catch (SQLException e) {
                    System.out.println("Error executing query: " + e.getMessage());
                }

            } catch (SQLException e) {
                System.out.println("Connection error: " + e.getMessage());
            }

        } catch (ClassNotFoundException e) {
            System.out.println("Error loading JDBC driver: " + e.getMessage());
        }
    }
}
