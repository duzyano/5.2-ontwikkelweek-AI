import { useState, useEffect } from 'react';
import { Station } from '../types';
import { getStations } from '../services/nsApi';

export const useStations = () => {
  const [stations, setStations] = useState<Station[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchStations = async () => {
      try {
        const stationsData = await getStations();
        setStations(stationsData);
        setError(null);
      } catch (err) {
        setError('Er is een fout opgetreden bij het ophalen van de stations');
      } finally {
        setLoading(false);
      }
    };

    fetchStations();
  }, []);

  const filterStations = (input: string, excludeStation = '') => {
    if (!input || input.length < 2) return [];
    return stations
      .filter(station => 
        station.name.toLowerCase().includes(input.toLowerCase()) && 
        station.name !== excludeStation
      )
      .slice(0, 8);
  };

  return { stations, loading, error, filterStations };
};