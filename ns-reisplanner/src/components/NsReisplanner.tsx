import React, { useState, useRef } from 'react';
import { Search, Calendar, Clock, ArrowRight, Train, AlertCircle } from 'lucide-react';
import { useStations } from '../hooks/useStations';
import { getTripAdvice } from '../services/nsApi';
import { Route } from '../types';

const NsReisplanner: React.FC = () => {
  const { filterStations } = useStations();
  const [van, setVan] = useState('');
  const [naar, setNaar] = useState('');
  const [datum, setDatum] = useState('');
  const [tijd, setTijd] = useState('');
  const [vertrekAankomst, setVertrekAankomst] = useState<'vertrek' | 'aankomst'>('vertrek');
  const [vanSuggestions, setVanSuggestions] = useState<string[]>([]);
  const [naarSuggestions, setNaarSuggestions] = useState<string[]>([]);
  const [showVanSuggestions, setShowVanSuggestions] = useState(false);
  const [showNaarSuggestions, setShowNaarSuggestions] = useState(false);
  const [reisadvies, setReisadvies] = useState<Route[]>([]);
  const [error, setError] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  
  const vanRef = useRef<HTMLDivElement>(null);
  const naarRef = useRef<HTMLDivElement>(null);

  // Initialize date and time
  React.useEffect(() => {
    const now = new Date();
    setDatum(now.toISOString().split('T')[0]);
    setTijd(now.toTimeString().slice(0, 5));
  }, []);

  const handleVanChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = e.target.value;
    setVan(value);
    setVanSuggestions(filterStations(value, naar).map(station => station.name));
    setShowVanSuggestions(true);
  };

  const handleNaarChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = e.target.value;
    setNaar(value);
    setNaarSuggestions(filterStations(value, van).map(station => station.name));
    setShowNaarSuggestions(true);
  };

  const selectVanStation = (station: string) => {
    setVan(station);
    setShowVanSuggestions(false);
  };

  const selectNaarStation = (station: string) => {
    setNaar(station);
    setShowNaarSuggestions(false);
  };

  const wisselStations = () => {
    const temp = van;
    setVan(naar);
    setNaar(temp);
  };

  const zoekReis = async () => {
    setError('');
    setIsLoading(true);
    
    if (!van || !naar) {
      setError('Vul alstublieft een vertrek- en aankomststation in');
      setIsLoading(false);
      return;
    }

    try {
      const datetime = `${datum}T${tijd}:00`;
      const routes = await getTripAdvice(van, naar, datetime, vertrekAankomst === 'aankomst');
      
      if (routes.length === 0) {
        setError('Geen reisadviezen gevonden voor de opgegeven reis');
      } else {
        setReisadvies(routes);
      }
    } catch (err) {
      setError('Er is een fout opgetreden bij het ophalen van de reisadviezen');
    } finally {
      setIsLoading(false);
    }
  };

  // Rest van de component (JSX) blijft hetzelfde...
  return (
    <div className="min-h-screen bg-gradient-to-b from-yellow-400 to-yellow-300">
      {/* Bestaande JSX hier... */}
    </div>
  );
};

export default NsReisplanner;