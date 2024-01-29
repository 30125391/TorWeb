import java.sql.*;
import java.util.InputMismatchException;
import java.util.Scanner;
import java.util.Random;

public class Main {
    public static void main(String[] args) {

        //JDBC URL, username, and password of MySQL server
        //String url = "jdbc:ucanaccess://C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\TorWeb\\Database Test\\TorWeb.accdb";
        //String url = "jdbc:ucanaccess://C:\\Users\\30115011\\OneDrive - NESCol\\SoftwareDev\\ProjectTestMk2\\TorWeb.accdb";
        String url = "jdbc:ucanaccess://C:/Users/Liamw/OneDrive - NESCol/digital skills/TorWeb/Database Test/TorWeb.accdb";
        String user = "";
        String password = "";


        try {
            // Load the JDBC driver
            Class.forName("net.ucanaccess.jdbc.UcanaccessDriver");

            // Establish a connection
            Connection connection = DriverManager.getConnection(url, user, password);

            // The SQL query, finds the database and prepares to input values into selected columns
            String sql = "INSERT INTO userDetails (ID, Password, DOB, Alias ,FirstName, LastName) VALUES (? ,? ,?, ?, ?, ? )";

            Statement statement = connection.createStatement();
            ResultSet results = statement.executeQuery("SELECT ID, Password, DOB, Alias ,FirstName, LastName FROM userDetails");

            // Get the data from the current row using the column index - column data are in the VARCHAR format

            ResultSetMetaData metaData = results.getMetaData();
            int columnCount = metaData.getColumnCount();

            if (columnCount > 0) {
                for (int i = 1; i <= columnCount; i++) {
                    System.out.println("Column " + i + ": " + metaData.getColumnName(i));

                }
            } else {
                System.out.println("No columns found in the result set.");
            }


            // MENU
            System.out.println("\n===============================================================================");
            System.out.println("1. To Sign In Type: [Sign In]");
            System.out.println("2. To Sign Up Type: [Sign Up]");
            System.out.println("===============================================================================\n");

            Scanner input = new Scanner(System.in);
            String answer = input.nextLine();

            if (answer.equalsIgnoreCase("sign up")){
                // Generate an ID based off a random number
                Random rnd = new Random();
                int ID = 100000 + rnd.nextInt(999999);

                // Read the ID and compare it to the exiting ID's
                try{
                    while (results.next()) {

                        // Get the data from the current row using the column index - column data are in the VARCHAR format
                        Integer data = results.getInt(1);
                        if (data.equals(ID)){ // If the ID is a copy deliver message
                            ID = 100000 + rnd.nextInt(999999);
                            break;
                        }
                    }

                } catch (Exception e) {
                    System.out.println("No Space Remaining");
                    e.printStackTrace();}


                // Create a Statement
                PreparedStatement preparedStatement = connection.prepareStatement(sql);

                // Get Statement from earlier in the code
                preparedStatement.setInt(1,ID);

                // Set values for the parameters
                Scanner input2 = new Scanner(System.in);
                System.out.println("please enter a password:\n>");
                preparedStatement.setString(2, input.nextLine());
                System.out.println("when is your Date Of Birth?:\n>");
                preparedStatement.setString(3, input.nextLine());
                System.out.println("what is your username?:\n>");
                preparedStatement.setString(4, input.nextLine());
                System.out.println("What is your first name?:\n>");
                preparedStatement.setString(5, input.nextLine());
                System.out.println("what is your surname?:\n>");
                preparedStatement.setString(6, input.nextLine());


                System.out.println("\n\nYour ID is: " + ID);
                // Execute the query
                preparedStatement.executeUpdate();

                connection.commit();
                // Close the resources
                preparedStatement.close();


            } else if (answer.equalsIgnoreCase("Sign in")) {
                try (Statement signInStatement = connection.createStatement()) {

                    Scanner input2 = new Scanner(System.in);

                    int attempts = 3;
                    boolean authenticated = false;

                    while (attempts > 0 && !authenticated) {
                        // Reload the ResultSet for each attempt
                        try (ResultSet signInResults = signInStatement.executeQuery("SELECT ID, Password FROM userDetails")) {
                            System.out.println("Please enter your ID:");
                            int userInputID = input.nextInt();
                            input.nextLine(); // Consume the newline character left by nextInt()

                            System.out.println("Please enter your password:");
                            String userInputPassword = input.nextLine();

                            while (signInResults.next()) {
                                int storedID = signInResults.getInt("ID");
                                String storedPassword = signInResults.getString("Password");

                                if (userInputID == storedID && userInputPassword.equals(storedPassword)) {
                                    authenticated = true;
                                    System.out.println("User authenticated!");
                                    break; // Exit the inner loop once a match is found
                                }
                            }

                            if (!authenticated) {
                                attempts--;
                                System.out.println("Incorrect ID or password. " + attempts + " attempts remaining.");
                            }
                        } catch (SQLException e) {
                            System.out.println("Error fetching user details");
                            e.printStackTrace();
                        }
                    }

                    if (!authenticated) {
                        System.out.println("Authentication failed after 3 attempts. Exiting...");
                    }

                } catch (InputMismatchException | SQLException e) {
                    System.out.println("Error in the Sign In process");
                    e.printStackTrace();
                }
            }




            connection.close();
        } catch (ClassNotFoundException | SQLException e) {
            e.printStackTrace();
        }
    }
}
