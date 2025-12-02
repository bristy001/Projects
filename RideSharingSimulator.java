
import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;

// Vehicle er type
enum VehicleType {
    BIKE, CAR, CNG
}

// Ride er status
enum RideStatus {
    REQUESTED, ASSIGNED, ONGOING, COMPLETED
}

// Jaygar nam + coordinate
class Location {
    private String name;
    private double x;
    private double y;

    public Location(String name, double x, double y) {
        this.name = name;
        this.x = x;
        this.y = y;
    }

    // Duto location er majher distance (simple Euclidean)
    public double distanceTo(Location other) {
        double dx = this.x - other.x;
        double dy = this.y - other.y;
        return Math.sqrt(dx * dx + dy * dy);
    }

    public String getName() {
        return name;
    }

    @Override
    public String toString() {
        return name + " (" + x + ", " + y + ")";
    }
}

// Common user
abstract class User {
    protected int id;
    protected String name;
    protected String phone;
    protected Location location;

    public User(int id, String name, String phone, Location location) {
        this.id = id;
        this.name = name;
        this.phone = phone;
        this.location = location;
    }

    public void updateLocation(Location newLocation) {
        this.location = newLocation;
    }

    public Location getLocation() {
        return location;
    }

    public String getName() {
        return name;
    }
}

// Rider
class Rider extends User {
    public Rider(int id, String name, String phone, Location location) {
        super(id, name, phone, location);
    }

    @Override
    public String toString() {
        return "Rider{" + name + ", phone='" + phone + "', loc=" + location + "}";
    }
}

// Driver
class Driver extends User {
    private VehicleType vehicleType;
    private boolean available;

    public Driver(int id, String name, String phone, Location location, VehicleType vehicleType) {
        super(id, name, phone, location);
        this.vehicleType = vehicleType;
        this.available = true;
    }

    public VehicleType getVehicleType() {
        return vehicleType;
    }

    public boolean isAvailable() {
        return available;
    }

    public void setAvailable(boolean available) {
        this.available = available;
    }

    @Override
    public String toString() {
        return "Driver{" + name + ", type=" + vehicleType +
                ", phone='" + phone + "', loc=" + location +
                ", available=" + available + "}";
    }
}

// Ride class – ekta ride er full info
class Ride {
    private static int counter = 1;

    private int rideId;
    private Rider rider;
    private Driver driver;
    private Location pickup;
    private Location dropoff;
    private double distanceKm;
    private double fare;
    private RideStatus status;

    public Ride(Rider rider, Location pickup, Location dropoff) {
        this.rideId = counter++;
        this.rider = rider;
        this.pickup = pickup;
        this.dropoff = dropoff;
        this.status = RideStatus.REQUESTED;
    }

    public int getRideId() {
        return rideId;
    }

    public Rider getRider() {
        return rider;
    }

    public Driver getDriver() {
        return driver;
    }

    public void setDriver(Driver driver) {
        this.driver = driver;
        this.status = RideStatus.ASSIGNED;
    }

    public void setDistanceKm(double distanceKm) {
        this.distanceKm = distanceKm;
    }

    public void setFare(double fare) {
        this.fare = fare;
    }

    public double getFare() {
        return fare;
    }

    public double getDistanceKm() {
        return distanceKm;
    }

    public RideStatus getStatus() {
        return status;
    }

    public void start() {
        if (status == RideStatus.ASSIGNED) {
            status = RideStatus.ONGOING;
        }
    }

    public void complete() {
        if (status == RideStatus.ONGOING) {
            status = RideStatus.COMPLETED;
        }
    }

    @Override
    public String toString() {
        return "Ride{" +
                "id=" + rideId +
                ", rider=" + rider.getName() +
                ", driver=" + (driver != null ? driver.getName() : "N/A") +
                ", pickup=" + pickup +
                ", dropoff=" + dropoff +
                ", distance=" + distanceKm + " km" +
                ", fare=" + fare +
                ", status=" + status +
                '}';
    }
}

// Fare calculation – base fare + per km
class FareCalculator {

    public double calculateFare(double distanceKm, VehicleType type) {
        double baseFare;
        double perKm;

        switch (type) {
            case BIKE:
                baseFare = 30;
                perKm = 12;
                break;
            case CNG:
                baseFare = 40;
                perKm = 15;
                break;
            case CAR:
            default:
                baseFare = 50;
                perKm = 20;
                break;
        }

        return baseFare + (perKm * distanceKm);
    }
}

// Nearest driver khuje ber kore
class MatchingService {

    public Driver findNearestDriver(List<Driver> drivers, Location pickup, VehicleType requestedType) {
        Driver nearest = null;
        double minDistance = Double.MAX_VALUE;

        for (Driver d : drivers) {
            if (!d.isAvailable() || d.getVehicleType() != requestedType) {
                continue;
            }

            double distance = d.getLocation().distanceTo(pickup);
            if (distance < minDistance) {
                minDistance = distance;
                nearest = d;
            }
        }

        return nearest;
    }
}

// Ride lifecycle handle kore: request → start → complete
class RideService {
    private MatchingService matchingService;
    private FareCalculator fareCalculator;

    public RideService(MatchingService matchingService, FareCalculator fareCalculator) {
        this.matchingService = matchingService;
        this.fareCalculator = fareCalculator;
    }

    public Ride requestRide(Rider rider, Location pickup, Location dropoff,
                            VehicleType vehicleType, List<Driver> drivers) {

        System.out.println("=== Ride Request ===");
        System.out.println("Rider: " + rider.getName());
        System.out.println("Pickup: " + pickup);
        System.out.println("Dropoff: " + dropoff);
        System.out.println("Requested vehicle: " + vehicleType);

        Ride ride = new Ride(rider, pickup, dropoff);

        Driver assignedDriver = matchingService.findNearestDriver(drivers, pickup, vehicleType);
        if (assignedDriver == null) {
            System.out.println("No available driver found for type: " + vehicleType);
            System.out.println("====================\n");
            return null;
        }

        ride.setDriver(assignedDriver);
        assignedDriver.setAvailable(false);

        double distance = pickup.distanceTo(dropoff);
        ride.setDistanceKm(distance);

        double estimatedFare = fareCalculator.calculateFare(distance, vehicleType);
        ride.setFare(estimatedFare);

        System.out.println("Driver assigned: " + assignedDriver.getName());
        System.out.println("Estimated distance: " + String.format("%.2f", distance) + " km");
        System.out.println("Estimated fare: " + String.format("%.2f", estimatedFare));
        System.out.println("Ride status: " + ride.getStatus());
        System.out.println("====================\n");

        return ride;
    }

    public void startRide(Ride ride) {
        System.out.println("Starting ride ID: " + ride.getRideId());
        ride.start();
        System.out.println("Ride status: " + ride.getStatus() + "\n");
    }

    public void completeRide(Ride ride) {
        System.out.println("Completing ride ID: " + ride.getRideId());
        ride.complete();
        ride.getDriver().setAvailable(true);

        System.out.println("=== Ride Summary ===");
        System.out.println("Ride ID: " + ride.getRideId());
        System.out.println("Rider: " + ride.getRider().getName());
        System.out.println("Driver: " + ride.getDriver().getName());
        System.out.println("Distance: " + String.format("%.2f", ride.getDistanceKm()) + " km");
        System.out.println("Final Fare: " + String.format("%.2f", ride.getFare()));
        System.out.println("Final Status: " + ride.getStatus());
        System.out.println("====================\n");
    }
}

// Main class
public class RideSharingSimulator {

    // Jaygar nam theke Location object ber kore (fixed map)
    private static Location getLocationByName(Scanner sc, String which) {
        while (true) {
            System.out.print(which + " jaygar nam din (UTTARA/MIRPUR/DHANMONDI): ");
            String input = sc.nextLine().trim().toUpperCase();

            switch (input) {
                case "UTTARA":
                    return new Location("Uttara", 0, 0);
                case "MIRPUR":
                    return new Location("Mirpur", 2, 3);
                case "DHANMONDI":
                    return new Location("Dhanmondi", 5, 5);
                default:
                    System.out.println("Unknown jayga. Available: UTTARA, MIRPUR, DHANMONDI.");
            }
        }
    }

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        // Sample drivers (database er moto)
        List<Driver> drivers = new ArrayList<>();
        drivers.add(new Driver(1, "Rahim", "01711", new Location("Uttara", 0, 0), VehicleType.CAR));
        drivers.add(new Driver(2, "Karim", "01712", new Location("Mirpur", 2, 3), VehicleType.BIKE));
        drivers.add(new Driver(3, "Sadia", "01713", new Location("Dhanmondi", 5, 5), VehicleType.CNG));
        drivers.add(new Driver(4, "Jamil", "01714", new Location("Mirpur", 1, 1), VehicleType.CAR));

        // Ekjon sample rider
        Rider r1 = new Rider(101, "Bristy", "01811", new Location("Uttara", 0, 1));

        
        MatchingService matchingService = new MatchingService();
        FareCalculator fareCalculator = new FareCalculator();
        RideService rideService = new RideService(matchingService, fareCalculator);

        System.out.println("=== Ride-Sharing Simulator (Interactive) ===");

        while (true) {
            System.out.println("\nNew ride request start korte Enter chapun...");
            sc.nextLine(); // just wait for Enter

            // pickup & dropoff jaygar nam diye nitechi
            Location pickup = getLocationByName(sc, "Pickup");
            Location dropoff = getLocationByName(sc, "Dropoff");

            // rider er current location update (optional but logical)
            r1.updateLocation(pickup);

            System.out.print("Vehicle type din (BIKE/CAR/CNG): ");
            String typeStr = sc.nextLine().trim().toUpperCase();

            VehicleType vehicleType;
            try {
                vehicleType = VehicleType.valueOf(typeStr);
            } catch (IllegalArgumentException e) {
                System.out.println("Invalid type, default CAR use kora hocche.");
                vehicleType = VehicleType.CAR;
            }

            Ride ride = rideService.requestRide(r1, pickup, dropoff, vehicleType, drivers);

            if (ride != null) {
                System.out.println("Ride start korte Enter chapun...");
                sc.nextLine();
                rideService.startRide(ride);

                System.out.println("Ride complete korte abar Enter chapun...");
                sc.nextLine();
                rideService.completeRide(ride);
            }

            System.out.print("Arekbar ride request korte chan? (y/n): ");
            String again = sc.nextLine().trim().toLowerCase();
            if (!again.equals("y")) {
                break;
            }
        }

        System.out.println("Simulator theke ber hoye jacche. Dhonnobad!");
        sc.close();
    }
}
